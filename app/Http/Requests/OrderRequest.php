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
            "customer_id" => ["required", "numeric"],
            "payment_type_id" => ["required", "numeric"],
            "payment_status" => ["required", "string"],
            "products" => ["required", "array"],
            "products.*.product_id" => ["required", "numeric"],
            "products.*.quantity" => ["required", "numeric"],
            
        ];
    }
}
