<?php

namespace Molitor\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Molitor\Order\Models\OrderStatus;

class StoreOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $orderStatus = $this->route('orderStatus');
        $ignoreId = $orderStatus instanceof OrderStatus ? $orderStatus->getKey() : null;

        return [
            'code' => ['required', 'string', 'max:50', Rule::unique('order_statuses', 'code')->ignore($ignoreId)],
            'name' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:50'],
        ];
    }
}
