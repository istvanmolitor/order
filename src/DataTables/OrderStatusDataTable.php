<?php

declare(strict_types=1);

namespace Molitor\Order\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Molitor\Admin\DataTables\DataTable;
use Molitor\Order\Http\Resources\OrderStatusResource;
use Molitor\Order\Models\OrderStatus;

class OrderStatusDataTable extends DataTable
{
    protected function getModelClass(): string
    {
        return OrderStatus::class;
    }

    protected function getResourceClass(): string
    {
        return OrderStatusResource::class;
    }

    protected function initColumns(): void
    {
        $this->addColumn('code')->setSearchable()->setOrderable();
        $this->addColumn('name')->setSearchable();
    }

    public function query(Builder $query): Builder
    {
        return $query->joinTranslation()->selectBase();
    }
}
