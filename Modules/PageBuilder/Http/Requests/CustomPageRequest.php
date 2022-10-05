<?php

namespace Modules\PageBuilder\Http\Requests;

use App\Traits\ValidationMessage;
use Illuminate\Foundation\Http\FormRequest;

class CustomPageRequest extends FormRequest
{
    use ValidationMessage;

    public function rules()
    {
        return [
            'title'=>'required|unique:custom_pages,title,'.$this->id,
            'slug'=>'required|unique:custom_pages,slug,'.$this->id,
        ];

    }

    public function authorize()
    {
        return true;
    }
}
