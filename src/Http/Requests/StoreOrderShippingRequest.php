<?php

namespace Molitor\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Molitor\Order\Models\OrderShipping;

class StoreOrderShippingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $orderShipping = $this->route('orderShipping');
        $ignoreId = $orderShipping instanceof OrderShipping ? $orderShipping->getKey() : null;

        return [
            'code' => ['required', 'string', 'max:50', Rule::unique('order_shippings', 'code')->ignore($ignoreId)],
            'translations' => ['required', 'array'],
            'translations.*.name' => ['required', 'string', 'max:255'],
            'translations.*.description' => ['nullable', 'string'],
            'type' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:50'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
