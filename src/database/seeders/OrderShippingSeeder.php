<?php

namespace Molitor\Order\database\seeders;

use Illuminate\Database\Seeder;
use Molitor\Order\Models\OrderShipping;
use Molitor\Order\Models\OrderPayment;

class OrderShippingSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'code' => 'pickup',
                'type' => 'simple',
                'name' => [
                    'hu' => 'Személyes átvétel',
                    'en' => 'In-store pickup',
                    'de' => 'Abholung im Geschäft',
                ],
                'description' => [
                    'hu' => 'Vegye át a rendelését személyesen az üzletünkben',
                    'en' => 'Pick up your order in person at our store',
                    'de' => 'Holen Sie Ihre Bestellung persönlich in unserem Geschäft ab',
                ],
            ],
            [
                'code' => 'courier',
                'type' => 'address',
                'name' => [
                    'hu' => 'Házhozszállítás futárral',
                    'en' => 'Home delivery (courier)',
                    'de' => 'Hauszustellung (Kurier)',
                ],
                'description' => [
                    'hu' => 'Kiszállítjuk a rendelését futárszolgálattal a megadott címre',
                    'en' => 'We deliver your order by courier to the specified address',
                    'de' => 'Wir liefern Ihre Bestellung per Kurier an die angegebene Adresse',
                ],
            ],
            [
                'code' => 'point',
                'type' => 'address',
                'name' => [
                    'hu' => 'Átvételi pont',
                    'en' => 'Pickup point',
                    'de' => 'Abholstelle',
                ],
                'description' => [
                    'hu' => 'Vegye át a rendelését egy kiválasztott átvételi ponton',
                    'en' => 'Pick up your order at a selected pickup point',
                    'de' => 'Holen Sie Ihre Bestellung an einer ausgewählten Abholstelle ab',
                ],
            ],
        ];

        foreach ($items as $data) {
            /** @var OrderShipping $shipping */
            $shipping = OrderShipping::firstOrNew(['code' => $data['code']]);
            $shipping->code = $data['code'];
            $shipping->type = $data['type'];

            foreach ($data['name'] as $locale => $name) {
                $shipping->setAttributeTranslation('name', $name, $locale);
            }

            foreach ($data['description'] as $locale => $description) {
                $shipping->setAttributeTranslation('description', $description, $locale);
            }

            $shipping->save();

            $allPayments = OrderPayment::all();
            if ($allPayments->isNotEmpty()) {
                $randomCount = rand(1, $allPayments->count());
                $randomPayments = $allPayments->random($randomCount)->pluck('id')->toArray();
                $shipping->payments()->sync($randomPayments);
            }
        }
    }
}
