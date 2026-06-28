<?php

namespace Molitor\Order\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Molitor\Order\DataTables\OrderStatusDataTable;
use Molitor\Order\Http\Requests\StoreOrderStatusRequest;
use Molitor\Order\Http\Resources\OrderStatusResource;
use Molitor\Order\Models\OrderStatus;
use Molitor\Order\Repositories\OrderStatusRepositoryInterface;

class OrderStatusApiController extends Controller
{
    public function __construct(
        private OrderStatusRepositoryInterface $orderStatusRepository
    ) {}

    public function index(OrderStatusDataTable $dataTable): AnonymousResourceCollection
    {
        return $dataTable->getResponse();
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
        $validated = $request->validated();

        $orderStatus = $this->orderStatusRepository->create(
            $validated['code'],
            $validated['color'] ?? null,
        );

        $orderStatus->setRequestTranslations($validated);
        $orderStatus->save();

        return response()->json(new OrderStatusResource($orderStatus->load('translations')), 201);
    }

    public function update(StoreOrderStatusRequest $request, OrderStatus $orderStatus): JsonResponse
    {
        $validated = $request->validated();

        $orderStatus->update([
            'code' => $validated['code'],
            'color' => $validated['color'] ?? null,
        ]);

        if (isset($validated['translations'])) {
            foreach ($validated['translations'] as $languageId => $translation) {
                $orderStatus->translations()->updateOrCreate(
                    ['language_id' => (int) $languageId],
                    [
                        'name' => $translation['name'] ?? '',
                        'description' => $translation['description'] ?? null,
                    ]
                );
            }
        }

        return response()->json(new OrderStatusResource($orderStatus->load('translations')));
    }

    public function destroy(OrderStatus $orderStatus): JsonResponse
    {
        $orderStatus->delete();

        return response()->json(null, 204);
    }
}
