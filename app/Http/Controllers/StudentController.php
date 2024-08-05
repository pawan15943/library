<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Grade;
use App\Models\Route;
use App\Models\State;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subscription;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        // $this->middleware('permission:student-list|student-edit|student-view', ['only' => ['index', 'show']]);
    }
    protected function validateUser(Request $request ,$id = null){
        $request->validate([
            'name' => 'required|string|max:50',
            'mobile' => 'required|string|max:10|min:10',
            'alt_mobile' => 'nullable|string|max:10|min:10',
            'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('students')->ignore($id),
            ],
            'father_name' => 'required|string|max:50',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'grade_id' => 'required|exists:grades,id',
            'stream' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:255',
            'pin_code' => 'required|string|max:6|min:6',
            'course_type_id' => 'required|exists:course_types,id',
            'course_id' => 'required|exists:courses,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:200',
        ]);
    }

    public function index(Request $request)
    {
        $user = auth()->user();
       
        $datas = Student::select('students.*','states.state_name','cities.city_name','grades.class_name','courses.course_name','course_types.name as course_type','courses.duration','courses.course_fees')
        ->leftJoin('states', 'students.state_id', '=', 'states.id')
        ->leftJoin('cities', 'students.city_id', '=', 'cities.id')
        ->leftJoin('grades', 'students.grade_id', '=', 'grades.id')
        ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
        ->leftJoin('course_types', 'courses.course_type', '=', 'course_types.id')
        ->orderBy('students.created_at', 'DESC')->get();
     
        if ($request->ajax()) {
            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('is_paid', function($row){
                    return $row->is_paid == 1 ? 'Yes' : 'No';
                })
                ->addColumn('is_completed', function($row){
                    return $row->status == 0 ? 'Yes' : 'No';
                })
                ->addColumn('is_certificate', function($row){
                    return $row->is_certificate == 1 ? 'Yes' : 'No';
                })
                ->addColumn('action', function ($row) use ($user) {
                    $btn = '<ul class="actionables">';
                    $btn .= '<li><a href="' . route('student.edit', $row->id) . '"  title="Edit Student"><i class="fas fa-edit"></i></a></li>
                        <li><a href="' . route('student.show', $row->id) . '" title="View Student"><i class="fas fa-eye"></i></a></li>
                        <li><a href="#"  data-id="' . $row->id . '" title="Delete Student"><i class="fas fa-trash"></i></a></li>
                         <li><a href="' . route('admin.accounts_payment', $row->id) . '"  title="make payment"><i class="fas fa-credit-card"></i></a></li>
                        <li><a href="javascript:void(0)"  data-id="' . $row->id . '" title="Certificate Status"><i class="fas fa-certificate"></i></a></li>
                        <li><a href="javascript:void(0)"  data-id="' . $row->id . '" title="Active Status"><i class="fas fa-star"></i></a></li>';
                    $btn .= '</ul>';
                    return $btn;
                })
                ->rawColumns(['contact_info', 'action'])
                ->make(true);
        }
    
        return view('student.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = Grade::all();
        $states = State::all();
        $course_types = CourseType::all();
       
        return view('student.create', compact('grades', 'states', 'course_types'));
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        
        $validated = $this->validateUser($request);
        $validated['form_no']=$this->getNewFormNumber();

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filePath = $file->store('uploade', 'public');
        }else{
            $filePath=null;
        }

        $validated['profile_image']=$filePath;
        Student::create($validated);

        return redirect()->route('student.index')->with('success', 'Student created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::select(
            'students.*',
            'states.state_name',
            'cities.city_name',
            'grades.class_name',
            'courses.course_name',
            'course_types.name as course_type',
            'courses.duration',
            'courses.course_fees'
        )
        ->leftJoin('states', 'students.state_id', '=', 'states.id')
        ->leftJoin('cities', 'students.city_id', '=', 'cities.id')
        ->leftJoin('grades', 'students.grade_id', '=', 'grades.id')
        ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
        ->leftJoin('course_types', 'courses.course_type', '=', 'course_types.id')
        ->where('students.id', $id)
        ->firstOrFail();

        return view('student.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find the student by ID
        $student = Student::find($id);

        // Fetch the required data for the form
        $grades = Grade::all();
        $states = State::all();
        $cities = City::where('state_id',$student->state_id)->pluck('id','city_name');
        $course_types = CourseType::all();
        $courses = Course::where('course_type',$student->course_type_id)->pluck('id','course_name');
        $fees=Course::where('id',$student->course_id)->select('course_fees','duration')->first();
       
        // Check if the student exists
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }
       
        // Pass the student data to the view
        return view('student.create', compact('student', 'grades', 'states', 'course_types', 'courses','cities','fees'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $validated = $this->validateUser($request, $id);
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filePath = $file->store('uploade', 'public');
        }else{
            $filePath=null;
        }

        $validated['profile_image']=$filePath;
        
        Student::where("id", $id)->update($validated);
        return redirect()->route('student.index')->with('success', 'Student Update successfully.');
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
    
        return response()->json(['success' => 'Student deleted successfully.']);
    }

    
    public function stateWiseCity(Request $request){
       
        if($request->state_id){
            $stateId=$request->state_id;
            $city=City::where('state_id',$stateId)->pluck('city_name','id');
           
            return response()->json($city);
        }
        
       
    }

    public function getCity($state_id)
    {
        $cities = City::where('state_id', $state_id)->pluck('city_name', 'id');
        return response()->json($cities);
    }

    public function getCourse($course_type_id)
    {
        
        $courses = Course::where('course_type', $course_type_id)->pluck('course_name', 'id');
        return response()->json($courses);
    }

    public function getCourseDetails($course_id)
    {
        $course = Course::find($course_id);
        $courseDetails = [
            'duration' => $course->duration,
            'fees' => $course->course_fees,
        ];
        return response()->json($courseDetails);
    }
    public function getNewFormNumber()
    {
      
        $form_num=250000001;
        
        if(Student::select('form_no')->count()>0)
        {
            $get_last_form=Student::select('form_no')->where('form_no','>','250000000')->orderBy('form_no', 'desc')->first();
            if(isset($get_last_form->form_num) && !empty($get_last_form->form_num))
            {
                $form_num=$get_last_form->form_num;
                $form_num++;
            }
            
        }
        while (Student::select('form_no')->where('form_no',"=",$form_num)->count()>0) {
            $form_num++;
        }
        return $form_num;
    }

    public function toggleActive($id)
    {
        
        $student = Student::findOrFail($id);
        if ($student->status == 0) {
            $student->status = 1;
        } else {
            $student->status = 0;
        };
        $student->save();

        return response()->json(['success' => 'Student status updated successfully.']);
    }

    public function toggleCertificate($id)
    {
        $student = Student::findOrFail($id);
        if ($student->is_certificate == 0) {
            $student->is_certificate = 1;
        } else {
            $student->is_certificate = 0;
        };
        $student->save();
      

        return response()->json(['success' => 'Student certificate status updated successfully.']);
    }

   

}
