<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
       
        $plan=Menu::all();
        return view('master.menu',compact('plan'));
    }
    public function create ()
    {
        $menus=Menu::all();
        return view('master.menu',compact('menus'));
    }
    public function edit($id)
    {
        $menus=Menu::all();
        $menu=Menu::find($id);
        return view('master.menu', compact('menu','menus'));
    }
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'order' => 'required',
        'slug' => 'required',
        'url' => 'required',
        ]);
        
        Menu::create(
           $request->all()
        );
        return redirect()->back()->with('success', 'Data created successfully.');
    }
    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:menus,id',
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'slug' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $menu = Menu::find($validatedData['id']);

        // Update the menu with the new data
        try {
            $update = $menu->update($validatedData);
            return redirect()->route('menu.create')->with('success', 'Menu updated successfully.');
        } catch (\Exception $e) {
            Log::error('Update Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update the menu.');
        }

 
    }

    public function submenu_index(Request $request)
    {
       
        $submenus=SubMenu::leftJoin('menus','menus.id','=','sub_menus.parent_id')->select('sub_menus.*','menus.name as menu_name')->get();
        return view('master.submenu',compact('submenus'));
    }
    public function submenu_create ()
    {
        $menu_list=Menu::all();
        $menus=SubMenu::all();
        $submenus=SubMenu::leftJoin('menus','menus.id','=','sub_menus.parent_id')->select('sub_menus.*','menus.name as menu_name')->get();

        return view('master.submenu',compact('menus','menu_list','submenus'));
    }
    public function submenu_edit($id)
    {
        $menu_list=Menu::all();
    
        $menu=SubMenu::find($id);
        $submenus=SubMenu::leftJoin('menus','menus.id','=','sub_menus.parent_id')->select('sub_menus.*','menus.name as menu_name')->get();

        return view('master.submenu', compact('menu','menu_list','submenus'));
    }
    public function submenu_store(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'order' => 'required',
        'slug' => 'required',
        'url' => 'required',
        'parent_id' => 'required',
        ]);
        
        SubMenu::create(
           $request->all()
        );
        return redirect()->back()->with('success', 'Data created successfully.');
    }
    

    public function submenu_update(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'slug' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'required|integer',
            'icon' => 'nullable|string|max:255',
        ]);

        // Find the SubMenu instance by ID
        $submenu = SubMenu::find($request->id);

        // Check if the SubMenu instance is found
        if (!$submenu) {
            return redirect()->back()->with('error', 'SubMenu not found.');
        }

        // Log the submenu before update
        Log::info('SubMenu Before Update: ', $submenu ? $submenu->toArray() : 'SubMenu not found');

        // Update the submenu with the new data
        try {
            $update = $submenu->update($validatedData);

            // Log the submenu after update
            Log::info('SubMenu After Update: ', $submenu->fresh() ? $submenu->fresh()->toArray() : 'SubMenu not found after update');
        } catch (\Exception $e) {
            Log::error('Update Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update the submenu.');
        }

        if ($update) {
            return redirect()->route('submenu.create')->with('success', 'SubMenu updated successfully.');
        } else {
            return redirect()->back()->with('error', 'SubMenu not updated successfully.');
        }
    }

        // Redirect back with a success message
       
  

}
