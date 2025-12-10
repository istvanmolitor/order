<?php

namespace Molitor\Order\database\seeders;

use Illuminate\Database\Seeder;
use Molitor\Order\Models\OrderPayment;

class OrderPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'code' => 'cash',
                'hu' => 'Készpénz',
                'en' => 'Cash',
                'de' => 'Barzahlung',
                'description' => null,
            ],
            [
                'code' => 'transfer',
                'hu' => 'Átutalás',
                'en' => 'Bank transfer',
                'de' => 'Überweisung',
                'description' => null,
            ],
            [
                'code' => 'card',
                'hu' => 'Bankkártya',
                'en' => 'Credit card',
                'de' => 'Kreditkarte',
                'description' => null,
            ],
        ];

        foreach ($items as $data) {
            /** @var OrderPayment $payment */
            $payment = OrderPayment::firstOrNew(['code' => $data['code']]);
            $payment->code = $data['code'];
            // translations
            $payment->setAttributeTranslation('name', $data['hu'], 'hu');
            $payment->setAttributeTranslation('name', $data['en'], 'en');
            $payment->setAttributeTranslation('name', $data['de'], 'de');
            if (!empty($data['description'])) {
                $payment->setAttributeTranslation('description', $data['description'], 'hu');
            }
            $payment->save();
        }
    }
}
