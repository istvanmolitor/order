<?php

namespace Molitor\Order\database\seeders;

use Illuminate\Database\Seeder;
use Molitor\Order\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['code' => 'ordered', 'hu' => 'Megrendelve', 'en' => 'Ordered', 'de' => 'Bestellt'],
            ['code' => 'paid', 'hu' => 'Fizetve', 'en' => 'Paid', 'de' => 'Bezahlt'],
            ['code' => 'shipped', 'hu' => 'Feladva', 'en' => 'Shipped', 'de' => 'Versandt'],
            ['code' => 'completed', 'hu' => 'Teljesítve', 'en' => 'Completed', 'de' => 'Abgeschlossen'],
            ['code' => 'cancelled', 'hu' => 'Törölve', 'en' => 'Cancelled', 'de' => 'Storniert'],
        ];

        foreach ($items as $data) {
            /** @var OrderStatus $status */
            $status = OrderStatus::firstOrNew(['code' => $data['code']]);
            $status->code = $data['code'];
            // translations
            $status->setAttributeTranslation('name', $data['hu'], 'hu');
            $status->setAttributeTranslation('name', $data['en'], 'en');
            $status->setAttributeTranslation('name', $data['de'], 'de');
            $status->save();
        }
    }
}
