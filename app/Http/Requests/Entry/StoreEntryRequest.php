<?php

namespace App\Http\Requests\Entry;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StoreEntryRequest extends FormRequest
{

    protected function prepareForValidation() {
        $this->merge([
            'user_id' => Auth::id()
        ]);
    }

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
            'name' => 'required',
            'login' => 'required',
            'password' => 'required',
            'site' => 'required',
            'description' => 'string',
            'user_id' => 'required|exists:users,id',
            'folder_id' => 'required|exists:folders,id'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'success' => 'false',
            'message' => 'Validation errors',
            'data' => $validator->errors(),
        ]));
    }


}
