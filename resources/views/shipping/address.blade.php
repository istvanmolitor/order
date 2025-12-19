<div class="shipping-address space-y-4">
    <div class="form-group">
        <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('order::common.name') }} <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            id="shipping_name"
            name="name"
            value="{{ old('name', $data['name'] ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            maxlength="255"
        >
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="shipping_country_id" class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('order::common.country') }} <span class="text-red-500">*</span>
        </label>
        <select
            id="shipping_country_id"
            name="country_id"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        >
            @php
                $selectedCountryId = old('country_id', $defaultCountryId);
            @endphp
            @foreach($countries as $id => $label)
                <option value="{{ $id }}" {{ $id == $selectedCountryId ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('country_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="form-group">
            <label for="shipping_zip_code" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('order::common.zip_code') }} <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="shipping_zip_code"
                name="zip_code"
                value="{{ old('zip_code', $data['zip_code'] ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                maxlength="10"
            >
            @error('zip_code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group md:col-span-2">
            <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('order::common.city') }} <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="shipping_city"
                name="city"
                value="{{ old('city', $data['city'] ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                maxlength="255"
            >
            @error('city')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('order::common.address') }} <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            id="shipping_address"
            name="address"
            value="{{ old('address', $data['address'] ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            maxlength="255"
            placeholder="{{ __('order::common.street_and_number') }}"
        >
        @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
