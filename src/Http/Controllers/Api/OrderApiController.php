<?php

namespace Molitor\Order\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Molitor\Order\Http\Resources\OrderResource;
use Molitor\Order\Http\Resources\OrderStatusResource;
use Molitor\Order\Models\Order;
use Molitor\Order\Models\OrderStatus;
use Molitor\Order\Repositories\OrderRepositoryInterface;
use OpenApi\Attributes as OA;

class OrderApiController extends Controller
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository
    ) {}

    #[OA\Get(
        path: '/api/admin/order/orders',
        summary: 'List all orders',
        tags: ['Orders'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Order')
                        ),
                        new OA\Property(
                            property: 'meta',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'current_page', type: 'integer'),
                                new OA\Property(property: 'last_page', type: 'integer'),
                                new OA\Property(property: 'per_page', type: 'integer'),
                                new OA\Property(property: 'total', type: 'integer'),
                            ]
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $query = Order::query()->with(['customer', 'orderStatus', 'orderItems']);

        if ($request->filled('search')) {
            $search = (string) $request->input('search');

            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('code', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search): void {
                        $customerQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $allowedSorts = ['id', 'code', 'created_at'];
        $sort = (string) $request->input('sort', 'code');
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'code';
        }

        $direction = strtolower((string) $request->input('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $orders = $query
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'data' => OrderResource::collection($orders->items()),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ],
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    #[OA\Get(
        path: '/api/admin/order/orders/create',
        summary: 'Show form for creating an order',
        tags: ['Orders'],
        responses: [
            new OA\Response(response: 200, description: 'Success'),
        ]
    )]
    public function create(): JsonResponse
    {
        $orderStatuses = OrderStatus::query()->get();

        return response()->json([
            'order_statuses' => OrderStatusResource::collection($orderStatuses),
        ]);
    }

    #[OA\Get(
        path: '/api/admin/order/orders/{id}',
        summary: 'Show a specific order',
        tags: ['Orders'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Success'),
            new OA\Response(response: 404, description: 'Order not found'),
        ]
    )]
    public function show(Order $order): JsonResponse
    {
        $order->load(['customer', 'orderStatus', 'orderItems.product.productImage', 'invoiceAddress', 'shippingAddress']);

        return response()->json(new OrderResource($order));
    }

    #[OA\Get(
        path: '/api/admin/order/orders/{id}/edit',
        summary: 'Show edit form for an order',
        tags: ['Orders'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Success'),
            new OA\Response(response: 404, description: 'Order not found'),
        ]
    )]
    public function edit(Order $order): JsonResponse
    {
        $order->load(['customer', 'orderStatus', 'orderItems.product.productImage', 'invoiceAddress', 'shippingAddress']);
        $orderStatuses = OrderStatus::query()->get();

        return response()->json([
            'data' => new OrderResource($order),
            'order_statuses' => OrderStatusResource::collection($orderStatuses),
        ]);
    }

    #[OA\Post(
        path: '/api/admin/order/orders',
        summary: 'Create a new order',
        tags: ['Orders'],
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Order data',
            content: new OA\JsonContent
        ),
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_status_id' => 'required|exists:order_statuses,id',
            'comment' => 'nullable|string',
            'internal_comment' => 'nullable|string',
            'phone' => 'nullable|string',
            'is_closed' => 'boolean',
        ]);

        $order = Order::create($validated);
        $order->load(['customer', 'orderStatus', 'orderItems']);

        return response()->json(new OrderResource($order), 201);
    }

    #[OA\Put(
        path: '/api/admin/order/orders/{id}',
        summary: 'Update an order',
        tags: ['Orders'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Order data',
            content: new OA\JsonContent
        ),
        responses: [
            new OA\Response(response: 200, description: 'Success'),
            new OA\Response(response: 404, description: 'Order not found'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function update(Request $request, Order $order): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => 'sometimes|required|exists:customers,id',
            'order_status_id' => 'sometimes|required|exists:order_statuses,id',
            'comment' => 'nullable|string',
            'internal_comment' => 'nullable|string',
            'phone' => 'nullable|string',
            'is_closed' => 'boolean',
        ]);

        $order->update($validated);
        $order->load(['customer', 'orderStatus', 'orderItems']);

        return response()->json(new OrderResource($order));
    }

    #[OA\Delete(
        path: '/api/admin/order/orders/{id}',
        summary: 'Delete an order',
        tags: ['Orders'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Deleted'),
            new OA\Response(response: 404, description: 'Order not found'),
        ]
    )]
    public function destroy(Order $order): JsonResponse
    {
        $this->orderRepository->delete($order);

        return response()->json(null, 204);
    }
}
