<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
       
        $plan=Menu::all();
        return view('menu',compact('plan'));
    }
    public function create ()
    {
        $menus=Menu::all();
        return view('menu',compact('menus'));
    }
    public function edit($id)
    {
        $menus=Menu::all();
        $menu=Menu::find($id);
        return view('menu', compact('menu','menus'));
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
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'slug' => 'required|string|max:255',
            'url' => 'required',
            'icon' => 'nullable|string|max:255',
        ]);

        // Update the menu with the new data
        $menu->update([
            'name' => $request->name,
            'order' => $request->order,
            'slug' => $request->slug,
            'url' => $request->url,
            'icon' => $request->icon,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Menu updated successfully.');
    }

    public function submenu_index(Request $request)
    {
       
        $plan=SubMenu::all();
        return view('submenu',compact('plan'));
    }
    public function submenu_create ()
    {
        $menu_list=Menu::all();
        $menus=SubMenu::all();
        return view('submenu',compact('menus','menu_list'));
    }
    public function submenu_edit($id)
    {
        $menu_list=Menu::all();
        $menus=SubMenu::all();
        $menu=SubMenu::find($id);
        return view('submenu', compact('menu','menus','menu_list'));
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
    public function submenu_update(Request $request, SubMenu $submenu)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'slug' => 'required|string|max:255',
            'url' => 'required',
            'parent_id' => 'required',
            'icon' => 'nullable|string|max:255',
        ]);

        // Update the menu with the new data
        $submenu->update([
            'name' => $request->name,
            'order' => $request->order,
            'slug' => $request->slug,
            'url' => $request->url,
            'icon' => $request->icon,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Menu updated successfully.');
    }

}
