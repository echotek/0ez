<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Redirect;
use Notifications;
use Illuminate\Contracts\Validation\Validator;

class StorePostRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'published_at' => ['required', 'regex:#^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$#s'],
        ];
    }

    public function response(Array $errors)
    {
        return Redirect::back()->withInput();
    }


    public function formatErrors(Validator $validator){
        foreach ($validator->errors()->all() as $error) {
            Notifications::add($error, 'danger');
        }

        return $validator->errors()->getMessages();
    }
}
