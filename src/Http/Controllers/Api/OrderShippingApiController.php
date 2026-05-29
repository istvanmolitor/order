<?php

namespace Molitor\Order\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Molitor\Admin\Traits\HasAdminFilters;
use Molitor\Order\Http\Requests\StoreOrderShippingRequest;
use Molitor\Order\Http\Resources\OrderShippingResource;
use Molitor\Order\Models\OrderShipping;
use Molitor\Order\Repositories\OrderShippingRepositoryInterface;

class OrderShippingApiController extends Controller
{
    use HasAdminFilters;

    public function __construct(
        private OrderShippingRepositoryInterface $orderShippingRepository
    ) {}

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
        $validated = $request->validated();

        $orderShipping = $this->orderShippingRepository->create(
            $validated['code'],
            $validated['type'] ?? null,
            $validated['color'] ?? null,
            isset($validated['price']) ? (float) $validated['price'] : null,
        );

        $orderShipping->setRequestTranslations($validated);
        $orderShipping->save();

        return response()->json(new OrderShippingResource($orderShipping->load('translations')), 201);
    }

    public function update(StoreOrderShippingRequest $request, OrderShipping $orderShipping): JsonResponse
    {
        $validated = $request->validated();

        $orderShipping->update([
            'code' => $validated['code'],
            'type' => $validated['type'] ?? null,
            'color' => $validated['color'] ?? null,
            'price' => isset($validated['price']) ? (float) $validated['price'] : null,
        ]);

        $orderShipping->setRequestTranslations($validated);
        $orderShipping->save();

        return response()->json(new OrderShippingResource($orderShipping->load('translations')));
    }

    public function destroy(OrderShipping $orderShipping): JsonResponse
    {
        $orderShipping->delete();

        return response()->json(null, 204);
    }
}
