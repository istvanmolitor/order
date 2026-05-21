<?php

namespace Molitor\Order\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Molitor\Admin\Traits\HasAdminFilters;
use Molitor\Order\Http\Requests\StoreOrderShippingRequest;
use Molitor\Order\Http\Resources\OrderShippingResource;
use Molitor\Order\Models\OrderShipping;

class OrderShippingApiController extends Controller
{
    use HasAdminFilters;

    public function index(Request $request): JsonResponse
    {
        $query = OrderShipping::query()->joinTranslation()->selectBase();
        $orderShippings = $this->applyAdminFilters($query, $request, ['code', 'name'])
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'data' => OrderShippingResource::collection($orderShippings->items()),
            'meta' => [
                'current_page' => $orderShippings->currentPage(),
                'last_page' => $orderShippings->lastPage(),
                'per_page' => $orderShippings->perPage(),
                'total' => $orderShippings->total(),
            ],
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    public function create(): JsonResponse
    {
        return response()->json([]);
    }

    public function show(OrderShipping $orderShipping): JsonResponse
    {
        return response()->json(new OrderShippingResource($orderShipping));
    }

    public function edit(OrderShipping $orderShipping): JsonResponse
    {
        return response()->json([
            'data' => new OrderShippingResource($orderShipping),
        ]);
    }

    public function store(StoreOrderShippingRequest $request): JsonResponse
    {
        $orderShipping = OrderShipping::create($request->validated());

        return response()->json(new OrderShippingResource($orderShipping), 201);
    }

    public function update(StoreOrderShippingRequest $request, OrderShipping $orderShipping): JsonResponse
    {
        $orderShipping->update($request->validated());

        return response()->json(new OrderShippingResource($orderShipping));
    }

    public function destroy(OrderShipping $orderShipping): JsonResponse
    {
        $orderShipping->delete();

        return response()->json(null, 204);
    }
}

