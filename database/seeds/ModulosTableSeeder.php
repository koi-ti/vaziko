<?php

use Illuminate\Database\Seeder;

use App\Models\Base\Modulo;

class ModulosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	Modulo::create([
        	'name' => 'administracion',
        	'display_name' => 'Administracion',
        	'nivel1' => 1
    	]);

        Modulo::create([
            'name' => 'cartera',
            'display_name' => 'Cartera',
            'nivel1' => 2
        ]);

    	Modulo::create([
        	'name' => 'contabilidad',
        	'display_name' => 'Contabilidad',
        	'nivel1' => 3
    	]);

    	Modulo::create([
        	'name' => 'inventario',
        	'display_name' => 'Inventario',
        	'nivel1' => 4
    	]);

    	Modulo::create([
        	'name' => 'produccion',
        	'display_name' => 'Produccion',
        	'nivel1' => 5
    	]);

        Modulo::create([
            'name' => 'tesoreria',
            'display_name' => 'Tesorería',
            'nivel1' => 6
        ]);

    	// Administracion
    	Modulo::create([
        	'display_name' => 'Modulos',
        	'nivel1' => 1,
        	'nivel2' => 1
    	]);

    	Modulo::create([
        	'display_name' => 'Referencias',
        	'nivel1' => 1,
        	'nivel2' => 2
    	]);

    	//Modulos
        Modulo::create([
        	'name' => 'empresa',
        	'display_name' => 'Empresa',
        	'nivel1' => 1,
        	'nivel2' => 1,
        	'nivel3' => 1
    	]);

    	Modulo::create([
        	'name' => 'terceros',
        	'display_name' => 'Terceros',
        	'nivel1' => 1,
        	'nivel2' => 1,
        	'nivel3' => 2
    	]);

    	Modulo::create([
        	'name' => 'roles',
        	'display_name' => 'Roles',
        	'nivel1' => 1,
        	'nivel2' => 1,
        	'nivel3' => 3
    	]);

    	//Referencias
    	Modulo::create([
        	'name' => 'actividades',
        	'display_name' => 'Actividades',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 1
    	]);

    	Modulo::create([
        	'name' => 'departamentos',
        	'display_name' => 'Departamentos',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 2
    	]);

    	Modulo::create([
        	'name' => 'municipios',
        	'display_name' => 'Municipios',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 4
    	]);

    	Modulo::create([
        	'name' => 'puntosventa',
        	'display_name' => 'Puntos de venta',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 6
    	]);

		Modulo::create([
        	'name' => 'sucursales',
        	'display_name' => 'Sucursales',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 7
    	]);

        // Cartera
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 2,
            'nivel2' => 1
        ]);

        Modulo::create([
            'display_name' => 'Reportes',
            'nivel1' => 2,
            'nivel2' => 2
        ]);

        // Modulos
        Modulo::create([
            'name' => 'facturas',
            'display_name' => 'Facturas',
            'nivel1' => 2,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

        // Reportes
        Modulo::create([
            'name' => 'rcarteraedades',
            'display_name' => 'Cartera por edades',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'restadocartera',
            'display_name' => 'Estado de cartera',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 2
        ]);

    	// Contabilidad
    	Modulo::create([
        	'display_name' => 'Modulos',
        	'nivel1' => 3,
        	'nivel2' => 1
    	]);

    	Modulo::create([
        	'name' => 'reportes',
        	'display_name' => 'Reportes',
        	'nivel1' => 3,
        	'nivel2' => 2
    	]);

    	Modulo::create([
        	'display_name' => 'Referencias',
        	'nivel1' => 3,
        	'nivel2' => 3
    	]);

    	//Modulos
        Modulo::create([
            'name' => 'asientos',
            'display_name' => 'Asientos',
            'nivel1' => 3,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

    	Modulo::create([
        	'name' => 'asientosnif',
        	'display_name' => 'Asientos NIF',
        	'nivel1' => 3,
        	'nivel2' => 1,
        	'nivel3' => 2
    	]);

    	Modulo::create([
        	'name' => 'cierresmensuales',
        	'display_name' => 'Cierre mensual',
        	'nivel1' => 3,
        	'nivel2' => 1,
        	'nivel3' => 3
    	]);

    	Modulo::create([
        	'name' => 'saldos',
        	'display_name' => 'Saldos',
        	'nivel1' => 3,
        	'nivel2' => 1,
        	'nivel3' => 4
    	]);

    	//Reportes
    	Modulo::create([
        	'name' => 'rauxcontable',
        	'display_name' => 'Auxiliar contable',
        	'nivel1' => 3,
        	'nivel2' => 2,
        	'nivel3' => 1
    	]);

    	Modulo::create([
        	'name' => 'rbalanceprueba',
        	'display_name' => 'Balance prueba',
        	'nivel1' => 3,
        	'nivel2' => 2,
        	'nivel3' => 2
    	]);

    	Modulo::create([
        	'name' => 'rauxbeneficiariocuenta',
        	'display_name' => 'Libro beneficiario/cuenta',
        	'nivel1' => 3,
        	'nivel2' => 2,
        	'nivel3' => 3
    	]);

    	Modulo::create([
        	'name' => 'rauxcuentabeneficiario',
        	'display_name' => 'Libro cuenta/beneficiario',
        	'nivel1' => 3,
        	'nivel2' => 2,
        	'nivel3' => 4
    	]);

    	Modulo::create([
        	'name' => 'rlibrodiario',
        	'display_name' => 'Libro diario',
        	'nivel1' => 3,
        	'nivel2' => 2,
        	'nivel3' => 5
    	]);

    	Modulo::create([
        	'name' => 'rlibromayor',
        	'display_name' => 'Libro mayor',
        	'nivel1' => 3,
        	'nivel2' => 2,
        	'nivel3' => 6
    	]);
    	Modulo::create([
        	'name' => 'rauxporcuenta',
        	'display_name' => 'Libro por cuenta',
        	'nivel1' => 3,
        	'nivel2' => 2,
        	'nivel3' => 7
    	]);

    	Modulo::create([
        	'name' => 'rmayorbalance',
        	'display_name' => 'Mayor y Balance',
        	'nivel1' => 3,
        	'nivel2' => 2,
        	'nivel3' => 8
    	]);

        Modulo::create([
        	'name' => 'rplancuentas',
        	'display_name' => 'Plan cuentas',
        	'nivel1' => 3,
        	'nivel2' => 2,
        	'nivel3' => 9
    	]);

    	Modulo::create([
        	'name' => 'rimpuestos',
        	'display_name' => 'Relación impuestos',
        	'nivel1' => 3,
        	'nivel2' => 2,
        	'nivel3' => 10
    	]);

    	//referencias
    	Modulo::create([
        	'name' => 'centroscosto',
        	'display_name' => 'Centros de costo',
        	'nivel1' => 3,
        	'nivel2' => 3,
        	'nivel3' => 1
    	]);

    	Modulo::create([
        	'name' => 'documentos',
        	'display_name' => 'Documentos',
        	'nivel1' => 3,
        	'nivel2' => 3,
        	'nivel3' => 2
    	]);

    	Modulo::create([
        	'name' => 'folders',
        	'display_name' => 'Folders',
        	'nivel1' => 3,
        	'nivel2' => 3,
        	'nivel3' => 3
    	]);

        Modulo::create([
            'name' => 'plancuentas',
            'display_name' => 'Plan de cuentas',
            'nivel1' => 3,
            'nivel2' => 3,
            'nivel3' => 4
        ]);

    	Modulo::create([
        	'name' => 'plancuentasnif',
        	'display_name' => 'Plan de cuentas NIF',
        	'nivel1' => 3,
        	'nivel2' => 3,
        	'nivel3' => 5
    	]);

    	//Inventario
    	Modulo::create([
        	'display_name' => 'Modulos',
        	'nivel1' => 4,
        	'nivel2' => 1
    	]);

    	Modulo::create([
        	'display_name' => 'Referencias',
        	'nivel1' => 4,
        	'nivel2' => 2
    	]);

    	//Modulos
    	Modulo::create([
        	'name' => 'productos',
        	'display_name' => 'Insumos',
        	'nivel1' => 4,
        	'nivel2' => 1,
        	'nivel3' => 1
    	]);

    	Modulo::create([
        	'name' => 'traslados',
        	'display_name' => 'Traslados',
        	'nivel1' => 4,
        	'nivel2' => 1,
        	'nivel3' => 2
    	]);

    	//Referencias
    	Modulo::create([
        	'name' => 'grupos',
        	'display_name' => 'Grupos',
        	'nivel1' => 4,
        	'nivel2' => 2,
        	'nivel3' => 1
    	]);

    	Modulo::create([
        	'name' => 'subgrupos',
        	'display_name' => 'Subgrupos',
        	'nivel1' => 4,
        	'nivel2' => 2,
        	'nivel3' => 2
    	]);

    	Modulo::create([
        	'name' => 'unidades',
        	'display_name' => 'Unidades',
        	'nivel1' => 4,
        	'nivel2' => 2,
        	'nivel3' => 3
    	]);

    	//Produccion
    	Modulo::create([
        	'display_name' => 'Modulos',
        	'nivel1' => 5,
        	'nivel2' => 1
    	]);

    	Modulo::create([
        	'display_name' => 'Reportes',
        	'nivel1' => 5,
        	'nivel2' => 2
    	]);

    	Modulo::create([
        	'display_name' => 'Referencias',
        	'nivel1' => 5,
        	'nivel2' => 3
    	]);

    	//Modulos
        Modulo::create([
            'name' => 'agendaordenes',
            'display_name' => 'Agenda',
            'nivel1' => 5,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'precotizaciones',
            'display_name' => 'Pre-cotizaciones',
            'nivel1' => 5,
            'nivel2' => 1,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'cotizaciones',
            'display_name' => 'Cotizaciones',
            'nivel1' => 5,
            'nivel2' => 1,
            'nivel3' => 3
        ]);

    	Modulo::create([
        	'name' => 'productosp',
        	'display_name' => 'Productos',
        	'nivel1' => 5,
        	'nivel2' => 1,
        	'nivel3' => 4
    	]);

    	Modulo::create([
        	'name' => 'ordenes',
        	'display_name' => 'Ordenes',
        	'nivel1' => 5,
        	'nivel2' => 1,
        	'nivel3' => 5
    	]);

    	Modulo::create([
        	'name' => 'tiemposp',
        	'display_name' => 'Tiempos',
        	'nivel1' => 5,
        	'nivel2' => 1,
        	'nivel3' => 6
    	]);

    	// Reportes
    	Modulo::create([
        	'name' => 'rtiemposp',
        	'display_name' => 'Tiempos',
        	'nivel1' => 5,
        	'nivel2' => 2,
        	'nivel3' => 1
    	]);

    	Modulo::create([
        	'name' => 'rresumentiemposp',
        	'display_name' => 'Tiempos de producción',
        	'nivel1' => 5,
        	'nivel2' => 2,
        	'nivel3' => 3
    	]);

    	//Referencias
    	Modulo::create([
        	'name' => 'acabadosp',
        	'display_name' => 'Acabados',
        	'nivel1' => 5,
        	'nivel2' => 3,
        	'nivel3' => 1
    	]);

    	Modulo::create([
        	'name' => 'actividadesp',
        	'display_name' => 'Actividades',
        	'nivel1' => 5,
        	'nivel2' => 3,
        	'nivel3' => 2
    	]);

    	Modulo::create([
        	'name' => 'areasp',
        	'display_name' => 'Areas',
        	'nivel1' => 5,
        	'nivel2' => 3,
        	'nivel3' => 3
    	]);

    	Modulo::create([
        	'name' => 'maquinasp',
        	'display_name' => 'Maquinas',
        	'nivel1' => 5,
        	'nivel2' => 3,
        	'nivel3' => 4
    	]);

    	Modulo::create([
        	'name' => 'materialesp',
        	'display_name' => 'Materiales',
        	'nivel1' => 5,
        	'nivel2' => 3,
        	'nivel3' => 5
    	]);

    	Modulo::create([
        	'name' => 'tipomaterialesp',
        	'display_name' => 'Tipo de material',
        	'nivel1' => 5,
        	'nivel2' => 3,
        	'nivel3' => 6
    	]);

    	Modulo::create([
        	'name' => 'tipoproductosp',
        	'display_name' => 'Tipo de producto',
        	'nivel1' => 5,
        	'nivel2' => 3,
        	'nivel3' => 7
    	]);

    	Modulo::create([
        	'name' => 'subactividadesp',
        	'display_name' => 'Subactividades',
        	'nivel1' => 5,
        	'nivel2' => 3,
        	'nivel3' => 8
    	]);

        Modulo::create([
        	'name' => 'subtipoproductosp',
        	'display_name' => 'Subtipo de producto',
        	'nivel1' => 5,
        	'nivel2' => 3,
        	'nivel3' => 9
    	]);

        //Tesoreria
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 6,
            'nivel2' => 1
        ]);

        Modulo::create([
            'display_name' => 'Reportes',
            'nivel1' => 6,
            'nivel2' => 2
        ]);

        // Modulos
        Modulo::create([
            'name' => 'facturasp',
            'display_name' => 'Factura proveedor',
            'nivel1' => 6,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

        // Reportes
        Modulo::create([
            'name' => 'rhistorialproveedores',
            'display_name' => 'Historial proveedores',
            'nivel1' => 6,
            'nivel2' => 2,
            'nivel3' => 1
        ]);
    }
}
