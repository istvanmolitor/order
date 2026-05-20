<?php

namespace Molitor\Order\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Order',
    title: 'Order',
    description: 'Order information',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'code', type: 'string', example: 'ORD-260520-ABC123'),
        new OA\Property(property: 'customer_id', type: 'integer', example: 1),
        new OA\Property(property: 'currency_id', type: 'integer', example: 1),
        new OA\Property(property: 'order_status_id', type: 'integer', example: 1),
        new OA\Property(property: 'is_closed', type: 'boolean', example: false),
        new OA\Property(property: 'comment', type: 'string', nullable: true),
        new OA\Property(property: 'internal_comment', type: 'string', nullable: true),
        new OA\Property(property: 'phone', type: 'string', nullable: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'customer_id' => $this->customer_id,
            'currency_id' => $this->currency_id,
            'order_status_id' => $this->order_status_id,
            'is_closed' => $this->is_closed,
            'comment' => $this->comment,
            'internal_comment' => $this->internal_comment,
            'phone' => $this->phone,
            'referer' => $this->referer,
            'invoice' => $this->invoice,
            'customer' => $this->whenLoaded('customer'),
            'orderStatus' => $this->whenLoaded('orderStatus'),
            'orderItems' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
