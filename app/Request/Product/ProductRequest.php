<?php

declare(strict_types=1);

namespace App\Request\Product;

use Hyperf\Validation\Request\FormRequest;

class ProductRequest extends FormRequest
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
     */
    public function rules(): array
    {
        switch ($this->getMethod())
        {
            case 'GET':
                $rules = [
                    'search' => 'nullable|string|between:2,50',
                    'order' => 'nullable|string|in:asc,desc',
                    'field' => 'nullable|string|in:sold_count,rating,review_count,price',
                ];
                return $rules;
                break;
            case 'POST':
                $rules = [
                    'title' => 'required|string|between:2,50',
                    'description' => 'required|string|between:2,1000',
                    'image' => 'required|url',
                    'on_sale' => 'required|integer|boolean',
                    'price' => 'required|numeric',
                ];
                return $rules;
                break;
            case 'PATCH':
                $rules = [
                    'id' => 'required|exists:products',
                    'title' => 'nullable|string|between:2,50',
                    'description' => 'nullable|string|between:2,1000',
                    'image' => 'nullable|url',
                    'on_sale' => 'nullable|integer|boolean',
                    'price' => 'nullable|numeric',
                ];
                return $rules;
                break;
            case 'DELETE':
                return [
                    'id' => 'required|exists:products',
                ];

        }
    }

    public function messages(): array
    {
        return [

        ];
    }
}
