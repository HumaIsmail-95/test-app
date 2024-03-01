<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request)
    {
        $route_id = $request->route('user')->id;


        if(empty($route_id) && $request->isMethod('put') ):
            $route_id = auth()->user()->id;
        endif;
        return [
            'name' => ['required', 'string', 'max:255'],
            'mobile_no' => ['required','numeric'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($route_id)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
