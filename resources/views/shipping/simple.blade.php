<form class="space-y-6">
    <div>
        <label for="contact" class="block text-sm font-medium text-gray-700">
            {{ __('order::common.contact') }}
        </label>
        <div class="mt-1">
            <textarea id="contact" name="contact" rows="4"
                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                      maxlength="255"
                      required>{{ old('contact', $contact ?? '') }}</textarea>
        </div>
        <p class="mt-2 text-sm text-gray-500">{{ __('order::common.contact') }}</p>
        @error('contact')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</form>
