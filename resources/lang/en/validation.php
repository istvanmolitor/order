<?php

return [
    'contact' => [
        'required' => 'The contact information is required.',
        'max' => 'The contact information may not be greater than :max characters.',
    ],
    'address' => [
        'required' => 'The address is required.',
        'name' => [
            'required' => 'The name field is required.',
            'max' => 'The name may not be greater than :max characters.',
        ],
        'country_id' => [
            'required' => 'The country selection is required.',
            'exists' => 'The selected country is invalid.',
        ],
        'zip_code' => [
            'required' => 'The zip code is required.',
            'max' => 'The zip code may not be greater than :max characters.',
        ],
        'city' => [
            'required' => 'The city is required.',
            'max' => 'The city may not be greater than :max characters.',
        ],
        'address' => [
            'required' => 'The address is required.',
            'max' => 'The address may not be greater than :max characters.',
        ],
    ],
];

