<form class="space-y-6">
    <div>
        <label for="address_name" class="block text-sm font-medium text-gray-700">
            {{ __('order::common.name') }}
        </label>
        <input id="address_name" name="address[name]" type="text"
               value="{{ old('address.name', $address['name'] ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               maxlength="255" required>
        @error('address.name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div>
            <label for="address_country_id" class="block text-sm font-medium text-gray-700">
                {{ __('order::common.country') }} (ID)
            </label>
            <input id="address_country_id" name="address[country_id]" type="number"
                   value="{{ old('address.country_id', $address['country_id'] ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   required>
            @error('address.country_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="address_zip_code" class="block text-sm font-medium text-gray-700">
                {{ __('order::common.zip_code') }}
            </label>
            <input id="address_zip_code" name="address[zip_code]" type="text"
                   value="{{ old('address.zip_code', $address['zip_code'] ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   maxlength="10" required>
            @error('address.zip_code')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="address_city" class="block text-sm font-medium text-gray-700">
                {{ __('order::common.city') }}
            </label>
            <input id="address_city" name="address[city]" type="text"
                   value="{{ old('address.city', $address['city'] ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   maxlength="255" required>
            @error('address.city')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="address_address" class="block text-sm font-medium text-gray-700">
            {{ __('order::common.address') }}
        </label>
        <input id="address_address" name="address[address]" type="text"
               value="{{ old('address.address', $address['address'] ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               maxlength="255" required>
        @error('address.address')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</form>
