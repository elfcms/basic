<?php

namespace Elfcms\Basic\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Basic\Models\Menu;
use Elfcms\Basic\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();
        return view('basic::admin.menu.menus.index',[
            'page' => [
                'title' => 'Menu',
                'current' => url()->current(),
            ],
            'menus' => $menus
        ]);
    }

    /**
     * Show the menu for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('basic::admin.menu.menus.create',[
            'page' => [
                'title' => 'Create menu',
                'current' => url()->current(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:App\Models\Menu,name',
            'code' => 'required|unique:App\Models\Menu,code',
        ]);

        $validated['description'] = $request->description;

        $menu = Menu::create($validated);

        return redirect(route('admin.menu.menus.edit',$menu->id))->with('menuedited',__('basic::elf.menu_created_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu, Request $request)
    {
        if ($request->ajax()) {
            return Menu::find($menu->id)->toJson();
        }
        $items = MenuItem::flat(menu_id: $menu->id);
        return view('basic::admin.menu.menus.show',[
            'page' => [
                'title' => 'Menu items',
                'current' => url()->current(),
            ],
            'items' => $items,
            'menu' => $menu
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return view('basic::admin.menu.menus.edit',[
            'page' => [
                'title' => 'Edit menu #' . $menu->id,
                'current' => url()->current(),
            ],
            'menu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required'
        ]);

        $menu->name = $validated['name'];
        $menu->code = $validated['code'];
        $menu->description = $request->description;

        $menu->save();

        return redirect(route('admin.menu.menus.edit',$menu->id))->with('menuedited',__('basic::elf.menu_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if (!$menu->delete()) {
            return redirect(route('admin.menu.menus'))->withErrors(['menudelerror'=>'Error of menu deleting']);
        }

        return redirect(route('admin.menu.menus'))->with('menudeleted','Menu deleted successfully');
    }
}
