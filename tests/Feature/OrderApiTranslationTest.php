<?php

declare(strict_types=1);

namespace Molitor\Order\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Molitor\Language\Models\Language;
use Tests\TestCase;

class OrderApiTranslationTest extends TestCase
{
    use RefreshDatabase;

    private Language $englishLanguage;

    private Language $hungarianLanguage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->englishLanguage = Language::query()->create([
            'enabled' => true,
            'code' => 'en',
        ]);

        $this->hungarianLanguage = Language::query()->create([
            'enabled' => true,
            'code' => 'hu',
        ]);
    }

    public function test_order_payment_requires_translations(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/admin/order/order-payments', [
            'code' => 'cash',
            'color' => '#22c55e',
            'price' => 0,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['translations']);
    }

    public function test_can_manage_order_payments_with_translations(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $createResponse = $this->postJson('/api/admin/order/order-payments', [
            'code' => 'cash',
            'translations' => [
                $this->englishLanguage->id => [
                    'name' => 'Cash',
                    'description' => 'Pay with cash on delivery',
                ],
                $this->hungarianLanguage->id => [
                    'name' => 'Készpénz',
                    'description' => 'Fizetés készpénzzel átvételkor',
                ],
            ],
            'color' => '#22c55e',
            'price' => 0,
        ]);

        $createResponse->assertCreated()
            ->assertJsonPath('code', 'cash')
            ->assertJsonCount(2, 'translations')
            ->assertJsonFragment([
                'language_id' => $this->englishLanguage->id,
                'name' => 'Cash',
                'description' => 'Pay with cash on delivery',
            ])
            ->assertJsonFragment([
                'language_id' => $this->hungarianLanguage->id,
                'name' => 'Készpénz',
                'description' => 'Fizetés készpénzzel átvételkor',
            ]);

        $paymentId = (int) $createResponse->json('id');

        $this->assertDatabaseHas('order_payment_translations', [
            'order_payment_id' => $paymentId,
            'language_id' => $this->englishLanguage->id,
            'name' => 'Cash',
            'description' => 'Pay with cash on delivery',
        ]);

        $this->assertDatabaseHas('order_payment_translations', [
            'order_payment_id' => $paymentId,
            'language_id' => $this->hungarianLanguage->id,
            'name' => 'Készpénz',
            'description' => 'Fizetés készpénzzel átvételkor',
        ]);

        $this->putJson("/api/admin/order/order-payments/{$paymentId}", [
            'code' => 'cash-updated',
            'translations' => [
                $this->englishLanguage->id => [
                    'name' => 'Cash payment',
                    'description' => 'Updated English description',
                ],
                $this->hungarianLanguage->id => [
                    'name' => 'Készpénzes fizetés',
                    'description' => 'Frissített magyar leírás',
                ],
            ],
            'color' => '#16a34a',
            'price' => 199,
        ])->assertOk()
            ->assertJsonPath('code', 'cash-updated')
            ->assertJsonFragment([
                'language_id' => $this->englishLanguage->id,
                'name' => 'Cash payment',
                'description' => 'Updated English description',
            ])
            ->assertJsonFragment([
                'language_id' => $this->hungarianLanguage->id,
                'name' => 'Készpénzes fizetés',
                'description' => 'Frissített magyar leírás',
            ]);

        $this->assertDatabaseHas('order_payments', [
            'id' => $paymentId,
            'code' => 'cash-updated',
            'color' => '#16a34a',
        ]);

        $this->assertDatabaseHas('order_payment_translations', [
            'order_payment_id' => $paymentId,
            'language_id' => $this->englishLanguage->id,
            'name' => 'Cash payment',
            'description' => 'Updated English description',
        ]);
    }

    public function test_can_manage_order_shippings_with_translations(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $createResponse = $this->postJson('/api/admin/order/order-shippings', [
            'code' => 'standard',
            'translations' => [
                $this->englishLanguage->id => [
                    'name' => 'Standard delivery',
                    'description' => 'Courier delivery in 2-3 days',
                ],
                $this->hungarianLanguage->id => [
                    'name' => 'Standard szállítás',
                    'description' => 'Futárszolgálat 2-3 napon belül',
                ],
            ],
            'type' => 'simple',
            'color' => '#f59e0b',
            'price' => 1490,
        ]);

        $createResponse->assertCreated()
            ->assertJsonPath('code', 'standard')
            ->assertJsonCount(2, 'translations')
            ->assertJsonFragment([
                'language_id' => $this->englishLanguage->id,
                'name' => 'Standard delivery',
                'description' => 'Courier delivery in 2-3 days',
            ])
            ->assertJsonFragment([
                'language_id' => $this->hungarianLanguage->id,
                'name' => 'Standard szállítás',
                'description' => 'Futárszolgálat 2-3 napon belül',
            ]);

        $shippingId = (int) $createResponse->json('id');

        $this->assertDatabaseHas('order_shipping_translations', [
            'order_shipping_id' => $shippingId,
            'language_id' => $this->englishLanguage->id,
            'name' => 'Standard delivery',
            'description' => 'Courier delivery in 2-3 days',
        ]);

        $this->putJson("/api/admin/order/order-shippings/{$shippingId}", [
            'code' => 'standard-updated',
            'translations' => [
                $this->englishLanguage->id => [
                    'name' => 'Standard shipping',
                    'description' => 'Updated courier delivery',
                ],
                $this->hungarianLanguage->id => [
                    'name' => 'Normál szállítás',
                    'description' => 'Frissített futárszolgálat',
                ],
            ],
            'type' => 'simple',
            'color' => '#d97706',
            'price' => 1990,
        ])->assertOk()
            ->assertJsonPath('code', 'standard-updated')
            ->assertJsonFragment([
                'language_id' => $this->englishLanguage->id,
                'name' => 'Standard shipping',
                'description' => 'Updated courier delivery',
            ])
            ->assertJsonFragment([
                'language_id' => $this->hungarianLanguage->id,
                'name' => 'Normál szállítás',
                'description' => 'Frissített futárszolgálat',
            ]);

        $this->assertDatabaseHas('order_shippings', [
            'id' => $shippingId,
            'code' => 'standard-updated',
            'type' => 'simple',
            'color' => '#d97706',
        ]);

        $this->assertDatabaseHas('order_shipping_translations', [
            'order_shipping_id' => $shippingId,
            'language_id' => $this->hungarianLanguage->id,
            'name' => 'Normál szállítás',
            'description' => 'Frissített futárszolgálat',
        ]);

    }
}
