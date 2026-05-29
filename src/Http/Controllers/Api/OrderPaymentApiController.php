<?php

namespace Molitor\Order\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Molitor\Admin\Traits\HasAdminFilters;
use Molitor\Order\Http\Requests\StoreOrderPaymentRequest;
use Molitor\Order\Http\Resources\OrderPaymentResource;
use Molitor\Order\Models\OrderPayment;
use Molitor\Order\Repositories\OrderPaymentRepositoryInterface;

class OrderPaymentApiController extends Controller
{
    use HasAdminFilters;

    public function __construct(
        private OrderPaymentRepositoryInterface $orderPaymentRepository
    ) {}

    public function index(Request $request): JsonResponse
    {
        $query = OrderPayment::query()->joinTranslation()->selectBase();
        $orderPayments = $this->applyAdminFilters($query, $request, ['code', 'name'])
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'data' => OrderPaymentResource::collection($orderPayments->items()),
            'meta' => [
                'current_page' => $orderPayments->currentPage(),
                'last_page' => $orderPayments->lastPage(),
                'per_page' => $orderPayments->perPage(),
                'total' => $orderPayments->total(),
            ],
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    public function create(): JsonResponse
    {
        return response()->json([]);
    }

    public function show(OrderPayment $orderPayment): JsonResponse
    {
        return response()->json(new OrderPaymentResource($orderPayment));
    }

    public function edit(OrderPayment $orderPayment): JsonResponse
    {
        return response()->json([
            'data' => new OrderPaymentResource($orderPayment),
        ]);
    }

    public function store(StoreOrderPaymentRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $orderPayment = $this->orderPaymentRepository->create(
            $validated['code'],
            $validated['name'],
            $validated['color'] ?? null,
            isset($validated['price']) ? (float) $validated['price'] : null,
        );

        return response()->json(new OrderPaymentResource($orderPayment), 201);
    }

    public function update(StoreOrderPaymentRequest $request, OrderPayment $orderPayment): JsonResponse
    {
        $orderPayment->update($request->validated());

        return response()->json(new OrderPaymentResource($orderPayment));
    }

    public function destroy(OrderPayment $orderPayment): JsonResponse
    {
        $orderPayment->delete();

        return response()->json(null, 204);
    }
}
