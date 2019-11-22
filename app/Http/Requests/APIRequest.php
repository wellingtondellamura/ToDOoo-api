<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class APIRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, new JsonResponse(
            [
                'success'=>'false',
                'message'=>'Informações inválidas.',
                'content'=> $validator->errors()
            ] , Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
