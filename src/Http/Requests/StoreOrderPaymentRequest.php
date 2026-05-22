<?php

namespace Molitor\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Molitor\Order\Models\OrderPayment;

class StoreOrderPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $orderPayment = $this->route('orderPayment');
        $ignoreId = $orderPayment instanceof OrderPayment ? $orderPayment->getKey() : null;

        return [
            'code' => ['required', 'string', 'max:50', Rule::unique('order_payments', 'code')->ignore($ignoreId)],
            'name' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:50'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
