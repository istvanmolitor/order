<?php

namespace Molitor\Order\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'OrderShipping',
    title: 'Order Shipping',
    description: 'Order shipping information',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'code', type: 'string', example: 'standard'),
        new OA\Property(property: 'name', type: 'string', example: 'Standard delivery'),
        new OA\Property(property: 'type', type: 'string', nullable: true, example: 'simple'),
        new OA\Property(property: 'color', type: 'string', nullable: true, example: '#f59e0b'),
        new OA\Property(property: 'price', type: 'number', format: 'float', nullable: true, example: 1490),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', nullable: true),
    ]
)]
class OrderShippingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'type' => $this->type,
            'color' => $this->color,
            'price' => $this->price,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
