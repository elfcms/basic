<?php

namespace Elfcms\Basic\Elf;

use Elfcms\Basic\Models\Form;
use Elfcms\Basic\Models\FormResult;
use Illuminate\Http\Request;

class FormSaver {

    public function __construct()
    {
        $this->name = null;
        $this->text = __('basic::elf.form_saving_general_error');
        $this->success = false;
        $this->id = null;

    }

    /**
     * Store a newly data from form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $this
     */
    public function save(Request $request)
    {
        $result = FormResult::create([
            'form_id' => $request->form_id,
            'form_data' => json_encode($request->all())
        ]);

        if ($result && $result->id) {
            $this->success = true;
            $this->name = 'success';
            $this->text = __('basic::elf.form_saving_success');
            $this->id = $result->id;
        }

        return $this;
    }

    public function toJson()
    {
        return $this->toJson();
    }

    /**
     * Read saved form data and join with fields params.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array $data
     */
    public static function read(FormResult $formResult) {

        $data = [];

        $resultData = json_decode($formResult->form_data,true);
        /* foreach ($resultData as $name => $value) {
            $data[$name] = $value;
        } */

        $form = Form::find($formResult->form_id);
        if (!empty($form->fields)) {
            foreach ($form->fields as $field) {
                $value = empty($resultData[$field->name]) ? null : $resultData[$field->name];
                $data[$field->name] = [
                    'title' => $field->title,
                    'descriotion' => $field->descriotion,
                    'type' => $field->type->name,
                    'value' => $value
                ];
            }
        }

        return $data;

    }

}
