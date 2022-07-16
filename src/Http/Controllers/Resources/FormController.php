<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormFieldGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $enctypes = [
        'application/x-www-form-urlencoded',
        'multipart/form-data',
        'text/plain'
    ];

    public function index()
    {
        $forms = Form::all();
        return view('basic::admin.form.forms.index',[
            'page' => [
                'title' => 'Forms',
                'current' => url()->current(),
            ],
            'forms' => $forms
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('basic::admin.form.forms.create',[
            'page' => [
                'title' => 'Create form',
                'current' => url()->current(),
            ],
            'enctypes' => $this->enctypes
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
            'code' => Str::slug($request->code,'_'),
            'name' => Str::slug($request->name),
        ]);
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:App\Models\Form,code',
        ]);
        $validated['description'] = $request->description;
        $validated['title'] = $request->title;
        $validated['action'] = $request->action;
        $validated['enctype'] = $request->enctype;
        $validated['method'] = "post";
        $validated['redirect_to'] = $request->redirect_to;
        $validated['submit_button'] = $request->submit_button;
        $validated['submit_name'] = $request->submit_name;
        $validated['submit_title'] = $request->submit_title;
        $validated['submit_value'] = $request->submit_value;
        $validated['reset_button'] = $request->reset_button;
        $validated['reset_title'] = $request->reset_title;
        $validated['reset_value'] = $request->reset_value;
        $validated['additional_buttons'] = '[{}]';

        $form = Form::create($validated);

        return redirect(route('admin.form.forms.edit',$form->id))->with('formcreated','Form created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        $groups = FormFieldGroup::where('form_id',$form->id)->get();
        $fields = FormField::where('form_id',$form->id)->get();
        return view('basic::admin.form.forms.show',[
            'page' => [
                'title' => 'Form #' . $form->id,
                'current' => url()->current(),
            ],
            'groups' => $groups,
            'fields' => $fields,
            'form' => $form
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        return view('basic::admin.form.forms.edit',[
            'page' => [
                'title' => 'Edit form #' . $form->id,
                'current' => url()->current(),
            ],
            'form' => $form,
            'enctypes' => $this->enctypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        $request->merge([
            'code' => Str::slug($request->code,'_'),
            'name' => Str::slug($request->name),
        ]);
        if ($request->code == $form->code) {
            $validated = $request->validate([
                'name' => 'required',
                'code' => 'required',
            ]);
        }
        else {
            $validated = $request->validate([
                'name' => 'required',
                'code' => 'required|unique:App\Models\Form,code',
            ]);
        }

        $form->name = $validated['name'];
        $form->code = $validated['code'];
        $form->description = $request->description;
        $form->title = $request->title;
        $form->action = $request->action;
        $form->enctype = $request->enctype;
        $form->method = "post";
        $form->redirect_to = $request->redirect_to;
        $form->submit_button = $request->submit_button;
        $form->submit_name = $request->submit_name;
        $form->submit_title = $request->submit_title;
        $form->submit_value = $request->submit_value;
        $form->reset_button = $request->reset_button;
        $form->reset_title = $request->reset_title;
        $form->reset_value = $request->reset_value;

        $form->save();

        return redirect(route('admin.form.forms.edit',$form->id))->with('formedited','Form edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        if (!$form->delete()) {
            return redirect(route('admin.form.forms'))->withErrors(['formdelerror'=>'Error of form deleting']);
        }

        return redirect(route('admin.form.forms'))->with('formdeleted','Form deleted successfully');
    }
}
