<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "receiver_name"=>["required", "string"],
            "receiver_phone"=>["required", "string"],
            "receiver_comment"=>["nullable"],

            'delivery_method_id' => 'required',
            'branch_id' => 'required_if:delivery_method_id,1|exists:branches,id',
            'region' => 'required_if:delivery_method_id,2|string',
            'district' => 'required_if:delivery_method_id,2|string',
            'address' => 'required_if:delivery_method_id,2|string',
            'latitude' => 'required_if:delivery_method_id,2|numeric',
            'longitude' => 'required_if:delivery_method_id,2|numeric',
            
            "payment_type_id" => ["required", "numeric"],
            
            "products" => ["required", "array"],
            "products.*.product_id" => ["required", "numeric"],
            "products.*.quantity" => ["required", "numeric"],
            
        ];
    }
}
