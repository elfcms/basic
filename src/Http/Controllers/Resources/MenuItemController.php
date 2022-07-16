<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = MenuItem::flat();
        return view('basic::admin.menu.items.index',[
            'page' => [
                'title' => 'Menu items',
                'current' => url()->current(),
            ],
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $menus = Menu::all();
        $menu_id = !empty($request->menu_id) ? $request->menu_id : null;
        if (empty($menu_id) && !empty($menus[0])) {
            $menu_id = $menus[0]->id;
        }
        $parent_id = null;
        if ($request->parent_id) {
            $parent_id = $request->parent_id;
            $parent_menu = MenuItem::find($parent_id);
            $menu_id = $parent_menu->menu_id;
        }
        $items = MenuItem::all();
        //dd($menu_id);
        return view('basic::admin.menu.items.create',[
            'page' => [
                'title' => 'Create menu item',
                'current' => url()->current(),
            ],
            'menus' => $menus,
            'menu_id' => $menu_id,
            'items' => $items,
            'parent_id' => $parent_id
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
        $request->merge([
            'clickable' => empty($request->clickable) ? 0 : 1
        ]);
        //dd($request);

        $attributes = [];
        foreach ($request->attributes_new as $attribute) {
            if (!empty($attribute['name'])) {
                $attributes[$attribute['name']] = $attribute['value'];
            }
        }

        $validated = $request->validate([
            'text' => 'required'
        ]);

        $validated['menu_id'] = $request->menu_id;
        $validated['link'] = $request->link;
        $validated['title'] = $request->title;
        $validated['handler'] = $request->handler;
        $validated['clickable'] = $request->clickable;
        $validated['attributes'] = $attributes;

        //dd($validated);
        $item = MenuItem::create($validated);

        return redirect(route('admin.menu.items.edit',$item->id))->with('menuitemedited',__('basic::elf.menu_item_created_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuItem $item, Request $request)
    {
        $menus = Menu::all();
        $items = MenuItem::where('id','<>',$item->id)->get();
        return view('basic::admin.menu.items.edit',[
            'page' => [
                'title' => 'Edit menu item',
                'current' => url()->current(),
            ],
            'menus' => $menus,
            'items' => $items,
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuItem $item)
    {
        $attributes = [];
        foreach ($request->attributes_new as $attribute) {
            if (!empty($attribute['name'])) {
                $attributes[$attribute['name']] = $attribute['value'];
            }
        }

        $request->merge([
            'clickable' => empty($request->clickable) ? 0 : 1,
        ]);

        $validated = $request->validate([
            'menu_id' => 'required'
        ]);

        $item->menu_id = $validated['menu_id'];
        $item->parent_id = $request->parent_id;
        $item->text = $request->text;
        $item->link = $request->link;
        $item->title = $request->title;
        $item->clickable = $request->clickable;
        $item->attributes = $attributes;

        $item->save();

        return redirect(route('admin.menu.items.edit',$item->id))->with('menuitemedited',__('basic::elf.menu_item_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
