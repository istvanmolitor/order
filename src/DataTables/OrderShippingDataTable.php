<?php

declare(strict_types=1);

namespace Molitor\Order\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Molitor\Admin\DataTables\DataTable;
use Molitor\Order\Http\Resources\OrderShippingResource;
use Molitor\Order\Models\OrderShipping;

class OrderShippingDataTable extends DataTable
{
    protected function getModelClass(): string
    {
        return OrderShipping::class;
    }

    protected function getResourceClass(): string
    {
        return OrderShippingResource::class;
    }

    protected function initColumns(): void
    {
        $this->addColumn('code')->setSearchable()->setOrderable();
        $this->addColumn('name')->setSearchable();
    }

    protected function getBaseQuery(): Builder
    {
        return OrderShipping::query()->joinTranslation()->selectBase();
    }
}
