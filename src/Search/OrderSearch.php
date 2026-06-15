<?php

declare(strict_types=1);

namespace Molitor\Order\Search;

use Molitor\Admin\Search\AdminSearch;
use Molitor\Admin\Search\AdminSearchResults;
use Molitor\Order\Models\Order;

class OrderSearch extends AdminSearch
{
    public function search(string $q, int $limit, AdminSearchResults $results): void
    {
        $this->filter(Order::query(), $q, ['code'])
            ->limit($limit)
            ->get()
            ->each(fn (Order $order) => $results->addResult(
                type: 'order',
                typeLabel: 'Megrendelés',
                id: $order->id,
                title: $order->code,
                subtitle: '',
                url: "/admin/order/orders/{$order->id}",
            ));
    }
}
