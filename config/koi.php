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
            'avatar' => '/images/avatar.svg',
            'header-pdf' => '/images/logo-header-pdf.png'
        ],
    	'ano' => 2015
    ],

    'meses' => [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ],

    'terceros' => [
        'tipo' => [
            'CC' => 'Cédula de Ciudadanía',
            'TI' => 'Tarjeta de Identidad',
            'CE' => 'Cédula de Extranjería',
            'PA' => 'Pasaporte', 'NI' => 'Nit'
        ],

        'regimen' => [
            1 => 'Simplificado',
            2 => 'Común',
            3 => 'Especial'
        ],

        'persona' => [
            'N' => 'Natural',
            'J' => 'Jurídica'
        ],

        'niif' => [
            '1' => 'Plena',
            '2' => 'Pymes',
            '3' => 'Micro pymes'
        ]
    ],

    'direcciones' => [
        'alfabeto' => [
            'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G', 'H' => 'H', 'I' => 'I',
            'J' => 'J', 'K' => 'K', 'L' => 'L', 'M' => 'M', 'N' => 'N', 'O' => 'O', 'P' => 'P', 'Q' => 'Q', 'R' => 'R',
            'S' => 'S', 'T' => 'T', 'U' => 'U', 'V' => 'V', 'W' => 'W', 'X' => 'X', 'Y' => 'Y', 'Z' => 'Z', 'BIS' => 'BIS'
        ],
        'cardinales' => [
            'SUR' => 'Sur',
            'ESTE' => 'Este',
            'NORTE' => 'Norte'
        ],
        'nomenclatura' => [
            'AD' => 'Administracion',
            'AG' => 'Agencia',
            'AGP' => 'Agrupación',
            'ALM' => 'Almacen',
            'AL' => 'Altillo',
            'APTDO' => 'Apartado',
            'AP' => 'Apartamento',
            'AUT' => 'Autopista',
            'AV' => 'Avenida',
            'AK' => 'Avenida Carrera',

            'BRR' => 'Barrio',
            'BL' => 'Bloque',
            'BG' => 'Bodega',
            'BLV' => 'Boulevar',
            'CL' => 'Calle',
            'CN' => 'Camino',
            'CR' => 'Carrera',
            'CARR' => 'Carretera',
            'CA' => 'Casa',
            'CEL' => 'Celula',

            'CC' => 'Centro Comercial',
            'CIR' => 'Circular',
            'CRV' => 'Circunvalar',
            'CD' => 'Ciudadela',
            'CONJ' => 'Conjunto',
            'CON' => 'Conjunto Residencial',
            'CS' => 'Consultorio',
            'CORR' => 'Corregimiento',
            'DPTO' => 'Departamento',
            'DP' => 'Deposito',

            'DS' => 'Deposito Sotano',
            'DG' => 'Diagonal',
            'ED' => 'Edificio',
            'EN' => 'Entrada',
            'ESQ' => 'Esquina',
            'ESTE' => 'Este',
            'ET' => 'Etapa',
            'EX' => 'Exterior',
            'FCA' => 'Finca',
            'GJ' => 'Garaje',

            'GS' => 'Garaje Sotano',
            'HC' => 'Hacienda',
            'IN' => 'Interior',
            'KM' => 'Kilometro',
            'LC' => 'Local',
            'LM' => 'Local Mezzanine',
            'LT' => 'Lote',
            'MZ' => 'Manzana',
            'MN' => 'Mezzanine',
            'MD' => 'Modulo',

            'MCP' => 'Municipio',
            'NORTE' => 'Norte',
            'OCC' => 'Occidente',
            'OESTE' => 'Oeste',
            'OF' => 'Oficina',
            'O' => 'Oriente',
            'PA' => 'Parcela',
            'PAR' => 'Parque',
            'PQ' => 'Parqueadero',
            'PJ' => 'Pasaje',

            'PS' => 'Paseo',
            'PH' => 'Penthouse',
            'P' => 'Piso',
            'PL' => 'Planta',
            'POR' => 'Porteria',
            'PD' => 'Predio',
            'PN' => 'Puente',
            'PT' => 'Puesto',
            'SA' => 'Salón',
            'SC' => 'Salón Comunal',

            'SEC' => 'Sector',
            'SS' => 'Semisotano',
            'SL' => 'Solar',
            'ST' => 'Sotano',
            'SU' => 'Suite',
            'SM' => 'Supermanzana',
            'SUR' => 'Sur',
            'TER' => 'Terminal',
            'TZ' => 'Terraza',
            'TO' => 'Torre',

            'TV' => 'Transversal',
            'UN' => 'Unidad',
            'UR' => 'Unidad Residencial',
            'URB' => 'Urbanización',
            'VTE' => 'Variante',
            'VDA' => 'Vereda',
            'ZN' => 'Zona',
            'ZF' => 'Zona Franca',
            '#' => '#',
            '-' => '-'
        ]
    ],

    'contabilidad' => [
        'plancuentas' => [
            'naturaleza' => [
                'D' => 'Débito',
                'C' => 'Crédito'
            ],
            'tipo' => [
                'N' => 'Ninguno',
                'I' => 'Inventario',
                'C' => 'Cartera',
                'P' => 'Cuentas por pagar'
            ],
            'niveles' => [
                '1' => 'Uno',
                '2' => 'Dos',
                '3' => 'Tres',
                '4' => 'Cuatro',
                '5' => 'Cinco',
                '6' => 'Seis',
                '7' => 'Siete',
                '8' => 'Ocho'
            ]
        ],

        'centrocosto' => [
            'tipo' => [
                'N' => 'Ninguno',
                'O' => 'Orden',
                'I' => 'Inventario'
            ]
        ],

        'documento' => [
            'consecutivo' => [
                'A' => 'Automático',
                'M' => 'Manual'
            ]
        ],

        'iva' => [
            '16' => '16%',
            '19' => '19%'
        ]
    ],

    'produccion' => [
        'formaspago' => [
            'CO' => 'Contado',
            'CT' => 'Crédito'
        ]
    ],

    'template' => [
        'bg' => 'bg-green'
    ],

    'close' => [
        'state' => [
            'R' => 'RECOTIZAR',
            'N' => 'NO ACEPTADA',
            'O' => 'AL ABRIR ORDEN'
        ]
    ]
];
