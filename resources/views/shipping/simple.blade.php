<div class="shipping-simple space-y-4">
    <div class="form-group">
        <label for="shipping_contact" class="block text-sm font-medium text-gray-700 mb-1">
            {{ __('order::common.contact') }} <span class="text-red-500">*</span>
        </label>
        <textarea
            id="shipping_contact"
            name="contact"
            rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            maxlength="255"
            placeholder="{{ __('order::common.contact_help') }}"
        >{{ old('contact', $data['contact'] ?? '') }}</textarea>
        @error('contact')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
