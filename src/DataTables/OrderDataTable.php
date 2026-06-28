<?php

declare(strict_types=1);

namespace Molitor\Order\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Molitor\Admin\DataTables\DataTable;
use Molitor\Order\Http\Resources\OrderResource;
use Molitor\Order\Models\Order;

class OrderDataTable extends DataTable
{
    protected function getModelClass(): string
    {
        return Order::class;
    }

    protected function getResourceClass(): string
    {
        return OrderResource::class;
    }

    protected function initColumns(): void
    {
        $this->addColumn('id')->setOrderable()->setHidden();
        $this->addColumn('code')->setLabel('Kód')->setSearchable()->setOrderable();
        $this->addColumn('created_at')->setLabel('Létrehozva')->setOrderable();
    }

    protected function getDefaultSort(): string
    {
        return 'code';
    }

    protected function getDefaultDirection(): string
    {
        return 'desc';
    }

    public function query(Builder $query): Builder
    {
        return $query->with(['customer', 'orderStatus', 'orderItems']);
    }

    protected function applyFilters(Builder $query): Builder
    {
        $search = $this->getSearch();

        if ($search === null) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('code', 'like', "%{$search}%")
                ->orWhereHas('customer', fn ($cq) => $cq->where('name', 'like', "%{$search}%"));
        });
    }
}
