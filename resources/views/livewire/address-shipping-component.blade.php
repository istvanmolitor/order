<div class="space-y-3">
    <div>
        <label for="shipping_name" class="block text-sm font-medium text-gray-700">
            {{ __('order::common.name') }} <span class="text-red-600">*</span>
        </label>
        <input id="shipping_name" wire:model.blur="shippingData.address.name" type="text"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('shippingData.address.name') border-red-300 @enderror"
               maxlength="255">
        @error('shippingData.address.name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div>
            <label for="shipping_country_id" class="block text-sm font-medium text-gray-700">
                {{ __('order::common.country') }} <span class="text-red-600">*</span>
            </label>
            <select id="shipping_country_id" wire:model.blur="shippingData.address.country_id"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('shippingData.address.country_id') border-red-300 @enderror">
                <option value="">{{ __('order::common.select_country') }}</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            @error('shippingData.address.country_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="shipping_zip_code" class="block text-sm font-medium text-gray-700">
                {{ __('order::common.zip_code') }} <span class="text-red-600">*</span>
            </label>
            <input id="shipping_zip_code" wire:model.blur="shippingData.address.zip_code" type="text"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('shippingData.address.zip_code') border-red-300 @enderror"
                   maxlength="10">
            @error('shippingData.address.zip_code')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="shipping_city" class="block text-sm font-medium text-gray-700">
                {{ __('order::common.city') }} <span class="text-red-600">*</span>
            </label>
            <input id="shipping_city" wire:model.blur="shippingData.address.city" type="text"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('shippingData.address.city') border-red-300 @enderror"
                   maxlength="255">
            @error('shippingData.address.city')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="shipping_address" class="block text-sm font-medium text-gray-700">
            {{ __('order::common.address') }} <span class="text-red-600">*</span>
        </label>
        <input id="shipping_address" wire:model.blur="shippingData.address.address" type="text"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('shippingData.address.address') border-red-300 @enderror"
               maxlength="255">
        @error('shippingData.address.address')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

