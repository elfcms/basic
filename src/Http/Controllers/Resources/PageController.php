<?php

namespace Elfcms\Basic\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Basic\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trend = 'asc';
        $order = 'id';
        if (!empty($request->trend) && $request->trend == 'desc') {
            $trend = 'desc';
        }
        if (!empty($request->order)) {
            $order = $request->order;
        }
        $pages = Page::orderBy($order, $trend)->paginate(30);
        return view('basic::admin.page.pages.index',[
            'page' => [
                'title' => 'Pages',
                'current' => url()->current(),
            ],
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('basic::admin.page.pages.create',[
            'page' => [
                'title' => 'Create page',
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
            'name' => 'required|unique:Elfcms\Basic\Models\Page,name',
            'slug' => 'required|unique:Elfcms\Basic\Models\Page,slug',
            'content' => 'required',
        ]);

        $validated['title'] = $request->title;
        $validated['meta_keywords'] = $request->meta_keywords;
        $validated['meta_description'] = $request->meta_description;

        $page = Page::create($validated);

        return redirect(route('admin.page.pages.edit',$page->id))->with('pageedited',__('basic::elf.page_created_successfully'));
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
    public function edit(Page $page)
    {
        return view('basic::admin.page.pages.edit',[
            'page' => [
                'title' => 'Edit page #' . $page->id,
                'current' => url()->current(),
            ],
            'page' => $page
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'content' => 'required'
        ]);

        $page->name = $validated['name'];
        $page->slug = $validated['slug'];
        $page->content = $validated['content'];
        $page->title = $request->title;
        $page->meta_keywords = $request->meta_keywords;
        $page->meta_description = $request->meta_description;

        $page->save();

        return redirect(route('admin.page.pages.edit',$page->id))->with('pageedited',__('basic::elf.page_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if (!$page->delete()) {
            return redirect(route('admin.page.pages'))->withErrors(['pagedelerror'=>'Error of page deleting']);
        }

        return redirect(route('admin.page.pages'))->with('pagedeleted','Page deleted successfully');
    }
}
