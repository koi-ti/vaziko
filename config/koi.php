<?php

return [
    'name' => 'KOI Tecnologías de la Información S.A.S.',
	'nickname' => 'KOI-TI',
	'site' => 'http://www.koi-ti.com',
	'image' => '/images/koi.png',

    'app' => [
    	'name' => 'Váziko',
    	'site' => 'http://www.vaziko.com', 	
    	
	    'image' => [
            'logo' => '/images/logo.png',
    		'avatar' => '/images/avatar.svg'
    	]
    ],

    'terceros' => [
        'tipo' => [
            'CC' => 'Cédula de Ciudadanía', 'TI' => 'Tarjeta de Identidad', 'CE' => 'Cédula de Extranjería', 'PA' => 'Pasaporte', 'NI' => 'Nit'
        ],

        'regimen' => [
            1 => 'Común', 2 => 'Simplificado', 3 => 'Especial'
        ],

        'persona' => [
            1 => 'Natural', 2 => 'Jurídica'
        ]
    ]
];
