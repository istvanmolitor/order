<div class="shipping-address-display space-y-2">
    <div class="flex">
        <span class="text-gray-600 font-medium w-32">{{ __('order::common.name') }}:</span>
        <span class="text-gray-900">{{ $name ?? '-' }}</span>
    </div>
    <div class="flex">
        <span class="text-gray-600 font-medium w-32">{{ __('order::common.country') }}:</span>
        <span class="text-gray-900">{{ $countryName ?? '-' }}</span>
    </div>
    <div class="flex">
        <span class="text-gray-600 font-medium w-32">{{ __('order::common.zip_code') }}:</span>
        <span class="text-gray-900">{{ $zip_code ?? '-' }}</span>
    </div>
    <div class="flex">
        <span class="text-gray-600 font-medium w-32">{{ __('order::common.city') }}:</span>
        <span class="text-gray-900">{{ $city ?? '-' }}</span>
    </div>
    <div class="flex">
        <span class="text-gray-600 font-medium w-32">{{ __('order::common.address') }}:</span>
        <span class="text-gray-900">{{ $address ?? '-' }}</span>
    </div>
</div>
