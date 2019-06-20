<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CreateDiary extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // falseから変更
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //key:inputタグのname属性
            //value:バリデーションの条件
            'title' => 'required|max:30', 
            'body' => 'required',
        ];
    }
}
