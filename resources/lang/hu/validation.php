<?php

return [
    'contact' => [
        'required' => 'A kapcsolattartási információ kitöltése kötelező.',
        'max' => 'A kapcsolattartási információ maximum :max karakter lehet.',
    ],
    'address' => [
        'required' => 'A cím kitöltése kötelező.',
        'name' => [
            'required' => 'A név mező kitöltése kötelező.',
            'max' => 'A név maximum :max karakter lehet.',
        ],
        'country_id' => [
            'required' => 'Az ország kiválasztása kötelező.',
            'exists' => 'A kiválasztott ország nem érvényes.',
        ],
        'zip_code' => [
            'required' => 'Az irányítószám kitöltése kötelező.',
            'max' => 'Az irányítószám maximum :max karakter lehet.',
        ],
        'city' => [
            'required' => 'A város kitöltése kötelező.',
            'max' => 'A város maximum :max karakter lehet.',
        ],
        'address' => [
            'required' => 'A cím kitöltése kötelező.',
            'max' => 'A cím maximum :max karakter lehet.',
        ],
    ],
];

