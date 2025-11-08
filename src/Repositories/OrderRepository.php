<?php

namespace Molitor\Order\Repositories;

use Illuminate\Support\Str;
use Molitor\Address\Repositories\AddressRepositoryInterface;
use Molitor\Currency\Models\Currency;
use Molitor\Customer\Models\Customer;
use Molitor\Order\Models\Order;
use Molitor\Order\Models\OrderStatus;

class OrderRepository implements OrderRepositoryInterface
{
    private Order $order;

    public function __construct(
        private AddressRepositoryInterface $addressRepository
    )
    {
        $this->order = new Order();
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }

    public function create(string $code, Customer $customer, Currency $currency, OrderStatus $orderStatus): Order
    {
        return $this->order->create([
            'is_closed' => true,
            'code' => $code,
            'customer_id' => $customer->id,
            'order_status_id' => $orderStatus->id,
            'currency_id' => $currency->id,
            'invoice_address_id' => $this->addressRepository->createEmptyId(),
            'shipping_address_id' => $this->addressRepository->createEmptyId(),
        ]);
    }

    public function getByCode(string $code): ?Order
    {
        return $this->order->where('code', $code)->first();
    }

    public function codeExists(string $code): bool
    {
        return $this->order->where('code', $code)->exists();
    }

    public function generateCode(): string
    {
        $date = now()->format('ymd');
        $prefix = 'ORD-' . $date . '-';
        do {
            $suffix = strtoupper(Str::random(6));
            $suffix = preg_replace('/[^A-Z0-9]/', substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', rand(0, 35), 1), $suffix);
            $code = $prefix . $suffix;
            $exists = $this->codeExists($code);
        } while ($exists);

        return $code;
    }
}
