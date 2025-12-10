<?php

namespace Molitor\Order\Listeners;

use Molitor\Currency\Events\DefaultCurrencyChanged;
use Molitor\Currency\Services\Price;
use Molitor\Order\Models\OrderShipping;

class DefaultCurrencyChangedListener
{
    public function handle(DefaultCurrencyChanged $event): void
    {
        // If there is no previous currency, we cannot recalculate persisted values reliably
        if ($event->previousCurrency === null) {
            return;
        }

        OrderShipping::query()
            ->select(['id', 'price'])
            ->chunkById(200, function ($shippings) use ($event) {
                foreach ($shippings as $shipping) {
                    $price = new Price((float) $shipping->price, $event->previousCurrency);
                    $exchanged = $price->exchange($event->currency);

                    // Update only if changed to avoid unnecessary writes
                    if ((float) $shipping->price !== (float) $exchanged->price) {
                        $shipping->price = $exchanged->price;
                        $shipping->save();
                    }
                }
            });
    }
}
