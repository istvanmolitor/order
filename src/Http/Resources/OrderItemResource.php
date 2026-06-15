<?php

namespace Molitor\Order\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'OrderItem',
    title: 'Order Item',
    description: 'Order item information',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'order_id', type: 'integer', example: 1),
        new OA\Property(property: 'product_id', type: 'integer', example: 1),
        new OA\Property(property: 'quantity', type: 'integer', example: 1),
        new OA\Property(property: 'price', type: 'number', format: 'float', example: 99.99),
        new OA\Property(
            property: 'product',
            type: 'object',
            nullable: true,
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 1),
                new OA\Property(property: 'sku', type: 'string', example: 'SKU-001'),
                new OA\Property(property: 'name', type: 'string', example: 'Termek neve'),
                new OA\Property(property: 'image_url', type: 'string', nullable: true, example: 'https://example.com/image.jpg'),
            ]
        ),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
class OrderItemResource extends JsonResource
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
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'product' => $this->whenLoaded('product', function (): array {
                $product = $this->product;

                return [
                    'id' => $product?->id,
                    'sku' => $product?->sku,
                    'name' => $product?->name,
                    'image_url' => $product?->relationLoaded('productImage') ? $product->productImage?->image_url : null,
                ];
            }),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
