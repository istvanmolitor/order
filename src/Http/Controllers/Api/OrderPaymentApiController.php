<?php

namespace Molitor\Order\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Molitor\Order\DataTables\OrderPaymentDataTable;
use Molitor\Order\Http\Requests\StoreOrderPaymentRequest;
use Molitor\Order\Http\Resources\OrderPaymentResource;
use Molitor\Order\Models\OrderPayment;
use Molitor\Order\Repositories\OrderPaymentRepositoryInterface;

class OrderPaymentApiController extends Controller
{
    public function __construct(
        private OrderPaymentRepositoryInterface $orderPaymentRepository
    ) {}

    public function index(OrderPaymentDataTable $dataTable): AnonymousResourceCollection
    {
        return $dataTable->getResponse();
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
            $validated['color'] ?? null,
            isset($validated['price']) ? (float) $validated['price'] : null,
        );

        $orderPayment->setRequestTranslations($validated);
        $orderPayment->save();

        return response()->json(new OrderPaymentResource($orderPayment->load('translations')), 201);
    }

    public function update(StoreOrderPaymentRequest $request, OrderPayment $orderPayment): JsonResponse
    {
        $validated = $request->validated();

        $orderPayment->update([
            'code' => $validated['code'],
            'color' => $validated['color'] ?? null,
            'price' => isset($validated['price']) ? (float) $validated['price'] : null,
        ]);

        $orderPayment->setRequestTranslations($validated);
        $orderPayment->save();

        return response()->json(new OrderPaymentResource($orderPayment->load('translations')));
    }

    public function destroy(OrderPayment $orderPayment): JsonResponse
    {
        $orderPayment->delete();

        return response()->json(null, 204);
    }
}
