<?php

namespace Molitor\Order\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Molitor\Admin\Traits\HasAdminFilters;
use Molitor\Order\Http\Requests\StoreOrderStatusRequest;
use Molitor\Order\Http\Resources\OrderStatusResource;
use Molitor\Order\Models\OrderStatus;

class OrderStatusApiController extends Controller
{
    use HasAdminFilters;

    public function index(Request $request): JsonResponse
    {
        $query = OrderStatus::query()->joinTranslation()->selectBase();
        $orderStatuses = $this->applyAdminFilters($query, $request, ['code', 'name'])
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'data' => OrderStatusResource::collection($orderStatuses->items()),
            'meta' => [
                'current_page' => $orderStatuses->currentPage(),
                'last_page' => $orderStatuses->lastPage(),
                'per_page' => $orderStatuses->perPage(),
                'total' => $orderStatuses->total(),
            ],
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    public function create(): JsonResponse
    {
        return response()->json([]);
    }

    public function show(OrderStatus $orderStatus): JsonResponse
    {
        return response()->json(new OrderStatusResource($orderStatus));
    }

    public function edit(OrderStatus $orderStatus): JsonResponse
    {
        return response()->json([
            'data' => new OrderStatusResource($orderStatus),
        ]);
    }

    public function store(StoreOrderStatusRequest $request): JsonResponse
    {
        $orderStatus = OrderStatus::create($request->validated());

        return response()->json(new OrderStatusResource($orderStatus), 201);
    }

    public function update(StoreOrderStatusRequest $request, OrderStatus $orderStatus): JsonResponse
    {
        $orderStatus->update($request->validated());

        return response()->json(new OrderStatusResource($orderStatus));
    }

    public function destroy(OrderStatus $orderStatus): JsonResponse
    {
        $orderStatus->delete();

        return response()->json(null, 204);
    }
}
