<div class="space-y-3">
    <div>
        <label for="shipping_contact" class="block text-sm font-medium text-gray-700">
            {{ __('order::common.contact') }} <span class="text-red-600">*</span>
        </label>
        <div class="mt-1">
            <textarea id="shipping_contact" wire:model.blur="shippingData.contact" rows="4"
                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('shippingData.contact') border-red-300 @enderror"
                      maxlength="255"></textarea>
        </div>
        <p class="mt-2 text-sm text-gray-500">{{ __('order::common.contact_help') }}</p>
        @error('shippingData.contact')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

