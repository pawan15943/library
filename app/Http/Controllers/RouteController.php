<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $routes = Route::all();
        if ($request->ajax()) {
            return DataTables::of($routes)
                ->addIndexColumn()
               
                
                ->addColumn('center', function ($row) {
                    $center=DB::table('study_centers')->where('id',$row->center_id)->first();
                    if($center){
                        return $center->name;
                    }
                    
                })
                ->addColumn('action', function ($row) use ($user) {
                    $btn = '<ul class="actionables">';
                  
                   
                    if ($user->can('student-edit')) {
                        $btn .= '<li><a href="' . route('route.edit', $row->id) . '"class="btn tooltips btn-default p-2 btn-sm rounded mr-2" title="Edit Route"><i class="fas fa-edit"></i></a></li>';
                    }
                    
                    $btn .= '</ul>';

                    return $btn;
                })
                ->rawColumns(['action', 'center'])
                ->make(true);
        }
        return view('route.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $arr_center=DB::table('study_centers')->where('country_id',6)->get();
        return view('route.create',compact('arr_center'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'center_id' => 'required',
            'name' => 'required',
            'areas' => 'required',
            'distance' => 'required|numeric',
        ]);
       
        Route::create($request->all());
        return redirect()->route('route.index')->with('success', 'Route created successfully.');
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
    public function edit(Route $route)
    {
        $arr_center=DB::table('study_centers')->where('country_id',6)->get();
        return view('route.create', compact('route','arr_center'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }
    public function update(Request $request, Route $route)
    {
        $request->validate([
            'center_id' => 'required',
            'name' => 'required',
            'areas' => 'required',
            'distance' => 'required|numeric',
        ]);

        $route->update($request->all());
        return redirect()->route('route.index')->with('success', 'Route updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
