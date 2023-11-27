<?php


namespace App\Http\Requests;


use App\Traits\ApiResponder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseFormRequest extends FormRequest
{
    use ApiResponder;

    public function authorize()
    {
        return true;
    }

    abstract protected function rules();

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $messages = $validator->getMessageBag()->all();

        $codes = $validator->failed();

        throw new HttpResponseException(
//            (in_array('exists', $messages) || in_array('exists', $codes))
//                ? $this->notFoundResponse($messages) :
                $this->badRequestResponse($messages)
        );

//        if (in_array('exists', $messages) || in_array('exists', $codes)) {
//            return $this->notFoundResponse($errors);
//        }
//        return $this->badRequestResponse($errors);
    }
}
