<div class="space-y-3">
    <div>
        <label for="shipping_data_address_name" class="block text-sm font-medium text-gray-700">
            {{ __('order::common.name') }}
        </label>
        <input id="shipping_data_address_name" name="shipping_data[address][name]" type="text"
               value="{{ old('shipping_data.address.name', $address['name'] ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               maxlength="255" required>
        @error('shipping_data.address.name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div>
            <label for="shipping_data_address_country_id" class="block text-sm font-medium text-gray-700">
                {{ __('order::common.country') }} (ID)
            </label>
            <input id="shipping_data_address_country_id" name="shipping_data[address][country_id]" type="number"
                   value="{{ old('shipping_data.address.country_id', $address['country_id'] ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   required>
            @error('shipping_data.address.country_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="shipping_data_address_zip_code" class="block text-sm font-medium text-gray-700">
                {{ __('order::common.zip_code') }}
            </label>
            <input id="shipping_data_address_zip_code" name="shipping_data[address][zip_code]" type="text"
                   value="{{ old('shipping_data.address.zip_code', $address['zip_code'] ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   maxlength="10" required>
            @error('shipping_data.address.zip_code')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="shipping_data_address_city" class="block text-sm font-medium text-gray-700">
                {{ __('order::common.city') }}
            </label>
            <input id="shipping_data_address_city" name="shipping_data[address][city]" type="text"
                   value="{{ old('shipping_data.address.city', $address['city'] ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   maxlength="255" required>
            @error('shipping_data.address.city')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="shipping_data_address_address" class="block text-sm font-medium text-gray-700">
            {{ __('order::common.address') }}
        </label>
        <input id="shipping_data_address_address" name="shipping_data[address][address]" type="text"
               value="{{ old('shipping_data.address.address', $address['address'] ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               maxlength="255" required>
        @error('shipping_data.address.address')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
