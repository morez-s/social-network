<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'caption' => ['bail', 'nullable', 'max:255'],
            'slide_file[*]' => ['bail', 'required', 'max:1000', 'mimes:png,jpg,jpeg,mp4,mov,avi,wmv'],
            'slide_order[*]' => ['bail', 'required', 'numeric', 'min:1'],
            'slide_tag_user_id[*][*]' => ['bail', 'sometimes', 'numeric', 'exists:users,id'],
            'slide_tag_horizontal_position[*][*]' => ['bail', 'sometimes', 'numeric', 'min:0'],
            'slide_tag_vertical_position[*][*]' => ['bail', 'sometimes', 'numeric', 'min:0'],
        ];
    }
}
