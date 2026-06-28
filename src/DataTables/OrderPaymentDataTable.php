<?php

declare(strict_types=1);

namespace Molitor\Order\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Molitor\Admin\DataTables\DataTable;
use Molitor\Order\Http\Resources\OrderPaymentResource;
use Molitor\Order\Models\OrderPayment;

class OrderPaymentDataTable extends DataTable
{
    protected function getModelClass(): string
    {
        return OrderPayment::class;
    }

    protected function getResourceClass(): string
    {
        return OrderPaymentResource::class;
    }

    protected function initColumns(): void
    {
        $this->addColumn('code')->setSearchable()->setOrderable();
        $this->addColumn('name')->setSearchable();
    }

    protected function getBaseQuery(): Builder
    {
        return OrderPayment::query()->joinTranslation()->selectBase();
    }
}
