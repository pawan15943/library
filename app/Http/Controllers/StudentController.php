<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subscription;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:student-list|student-edit|student-view', ['only' => ['index', 'show']]);
    }
    public function index(Request $request)
    {
        $user = auth()->user();
       
        $datas = Student::select('students.created_at','students.updated_at','students.is_paid','students.name as name','students.email as email','students.mobile_no as mobile_no','students.id as id','students.form_num as form_num','countries.name as countries_name','classes.name as classes_name','course_categories.name as stream')
       
        ->leftJoin('countries', 'students.country_id', '=', 'countries.id')
        ->leftJoin('classes', 'students.class_id', '=', 'classes.id')
        ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
        ->leftJoin('course_categories', 'courses.category_id', '=', 'course_categories.id')
        ->orderBy('students.created_at', 'DESC')
        ->where('students.country_id','=',6);
        if ($request->ajax()) {
            return DataTables::of($datas)
                ->addIndexColumn()
               
                ->addColumn('stream', function ($row) {
                    if($row->stream){
                        $stream=$row->stream;
                    }else{
                        $stream='NA';
                        
                    }
                   
                    if($stream=='PRE-NURTURE'){
                        return '<span class="pre-nurture">'.$stream.'</span>';
                    }elseif($stream=='JEE MAIN + ADVANCED'){
                        return '<span class="jee-main-advance">'.$stream.'</span>';
                    }elseif($stream=='PRE-MEDICAL'){
                        return '<span class="pre-medical">'.$stream.'</span>';
                    }else{
                        return '<span class="">'.$stream.'</span>';
                    }
                    
                })
                ->addColumn('fee_status', function ($row) {
                    return $row->is_paid == 1 ? 'Y':'N';
                })
                ->addColumn('action', function ($row) use ($user) {
                    $btn = '<ul class="actionables">';
                  
                   
                    if ($user->can('student-edit')) {
                        $btn .= '<li><a href="' . route('student.edit', $row->id) . '"class="btn tooltips btn-default p-2 btn-sm rounded mr-2" title="Edit Student"><i class="fas fa-edit"></i></a></li>';
                    }
                    
                    $btn .= '</ul>';

                    return $btn;
                })
                ->rawColumns(['action', 'stream'])
                ->make(true);
        }
        return view('student.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'student_id' => 'required',
            'form_num' => 'required',
            'route_id' => 'required',
            'landmark' => 'required',
            'amount' => 'required',
         
        ]);
        $validatedData['remark']=$request->remark;
        Subscription::create($validatedData);
        return redirect()->route('student.transportationList')->with('success', 'Data created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
        $student = Student::select('countries.name as countries_name', 'cities.name as cities', 'study_centers.name as study_centers', 'students.*','study_centers.code as study_center_code','course_categories.name as coursecategories', 'classes.name as classes')
        ->leftJoin('countries', 'students.country_id', '=', 'countries.id')
        ->leftJoin('cities', 'students.city_id', '=', 'cities.id')
        ->leftJoin('study_centers', 'students.center_id', '=', 'study_centers.id')
        ->leftJoin('classes', 'students.class_id', '=', 'classes.id')
        ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
        ->leftJoin('course_types', 'courses.course_type_id', '=', 'course_types.id')
        ->leftJoin('course_categories', 'courses.category_id', '=', 'course_categories.id')
        ->where("students.id", $id)
        ->first();

        $routes=Route::all();
        if(Subscription::where('student_id',$id)->count()>0){
            $subscri_id=Subscription::where('student_id',$id)->first();
        }else{
            $subscri_id=null;
        }
       
       
        return view('student.edit', compact('student','routes','subscri_id'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $validatedData = $request->validate([
            'student_id' => 'required',
            'form_num' => 'required',
            'route_id' => 'required',
            'landmark' => 'required',
            'amount' => 'required',
         
        ]);
        $validatedData['remark']=$request->remark;
        Subscription::where("id", $id)->update($validatedData);
        return redirect()->route('student.transportationList')->with('success', 'Transportation Detailes updated Successfully.');
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function transportationList(Request $request){
        $user = auth()->user();
       
        $datas =Subscription::all();

        if ($request->ajax()) {
            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('student_name', function ($row) {
                    $student=Student::where('id',$row->student_id)->value('name');
                    return $student;
                })
                ->addColumn('route_name', function ($row) {
                    $route_name=Route::where('id',$row->route_id)->value('name');
                    return $route_name;
                })
                ->addColumn('status', function ($row) {
                    
                    if($row->status==1){
                        return '<span class="pre-nurture">Approved</span>';
                    }elseif($row->status==2){
                        return '<span class="jee-main-advance">Reject</span>';
                    }else{
                        return '<span class="">Pending</span>';
                    }
                    
                })
                ->addColumn('van_is_paid', function ($row) {
                    return $row->van_isPaid == 1 ? 'Y':'N';
                })
                ->addColumn('action', function ($row) use ($user) {
                    $btn = '<ul class="actionables">';
                  
                   
                    if ($user->can('student-edit')) {
                        $btn .= '<li><a href="' . route('student.edit', $row->student_id) . '"class="btn tooltips btn-default p-2 btn-sm rounded mr-2" title="Edit Student"><i class="fas fa-edit"></i></a></li>';
                    }
                    
                    $btn .= '</ul>';

                    return $btn;
                })
                ->rawColumns(['action', 'student_name','van_is_paid','status','route_name'])
                ->make(true);
        }
        return view('admin.list');
    }
}
