<?php

namespace Molitor\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Molitor\Order\Models\OrderPayment;

class StoreOrderPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('acl', 'order');
    }

    public function rules(): array
    {
        $orderPayment = $this->route('orderPayment');
        $ignoreId = $orderPayment instanceof OrderPayment ? $orderPayment->getKey() : null;

        return [
            'code' => ['required', 'string', 'max:50', Rule::unique('order_payments', 'code')->ignore($ignoreId)],
            'translations' => ['required', 'array'],
            'translations.*.name' => ['required', 'string', 'max:255'],
            'translations.*.description' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:50'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
