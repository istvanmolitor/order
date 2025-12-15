<?php

namespace Molitor\Order\database\seeders;

use Illuminate\Database\Seeder;
use Molitor\Order\Models\OrderShipping;

class OrderShippingSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'code' => 'pickup',
                'type' => 'warehouse',
                'hu' => 'Személyes átvétel',
                'en' => 'In-store pickup',
                'de' => 'Abholung im Geschäft',
                'description' => null,
            ],
            [
                'code' => 'courier',
                'type' => 'address',
                'hu' => 'Házhozszállítás futárral',
                'en' => 'Home delivery (courier)',
                'de' => 'Hauszustellung (Kurier)',
                'description' => null,
            ],
            [
                'code' => 'point',
                'type' => 'address',
                'hu' => 'Átvételi pont',
                'en' => 'Pickup point',
                'de' => 'Abholstelle',
                'description' => null,
            ],
        ];

        foreach ($items as $data) {
            /** @var OrderShipping $shipping */
            $shipping = OrderShipping::firstOrNew(['code' => $data['code']]);
            $shipping->code = $data['code'];
            $shipping->type = $data['type'];
            // translations
            $shipping->setAttributeTranslation('name', $data['hu'], 'hu');
            $shipping->setAttributeTranslation('name', $data['en'], 'en');
            $shipping->setAttributeTranslation('name', $data['de'], 'de');
            if (!empty($data['description'])) {
                $shipping->setAttributeTranslation('description', $data['description'], 'hu');
            }
            $shipping->save();
        }
    }
}
