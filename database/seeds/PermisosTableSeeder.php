<?php

use Illuminate\Database\Seeder;

use App\Models\Base\Permiso;

class PermisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permiso::create([
            'name'   => 'consultar',
            'display_name'   => 'Consultar',
            'description'   => 'Permisos de consulta'
        ]);

        Permiso::create([
            'name'   => 'crear',
            'display_name'   => 'Crear',
            'description'   => 'Permisos de creacion'
        ]);

        Permiso::create([
            'name'   => 'editar',
            'display_name'   => 'Editar',
            'description'   => 'Permisos de editar'
        ]);

        Permiso::create([
            'name'   => 'eliminar',
            'display_name'   => 'Eliminar',
            'description'   => 'Permisos para eliminar'
        ]);

        Permiso::create([
            'name'   => 'precios',
            'display_name'   => 'Precios',
            'description'   => 'Permisos para ver precios'
        ]);

        Permiso::create([
            'name'   => 'cerrar',
            'display_name'   => 'Cerrar',
            'description'   => 'Permisos para cerrar'
        ]);

        Permiso::create([
            'name'   => 'abrir',
            'display_name'   => 'Abrir',
            'description'   => 'Permisos para abrir'
        ]);

        Permiso::create([
            'name'   => 'anular',
            'display_name'   => 'Anular',
            'description'   => 'Permisos para anular'
        ]);

        Permiso::create([
            'name'   => 'culminar',
            'display_name'   => 'Culminar',
            'description'   => 'Permisos para culminar'
        ]);

        Permiso::create([
            'name'   => 'clonar',
            'display_name'   => 'Clonar',
            'description'   => 'Permisos para clonar'
        ]);

        Permiso::create([
            'name'   => 'exportar',
            'display_name'   => 'Exportar',
            'description'   => 'Permiso para ver y/o exportar (pdf, excel)'
        ]);

        Permiso::create([
            'name'   => 'generar',
            'display_name'   => 'Generar',
            'description'   => 'Permiso para generar (Cotización y Orden de producción)'
        ]);

        Permiso::create([
            'name'   => 'utilidades',
            'display_name'   => 'Utilidades',
            'description'   => 'Permiso para ver utilidades (Cotización y Orden de producción)'
        ]);

        Permiso::create([
            'name'   => 'precotizar',
            'display_name'   => 'Pre-cotizar',
            'description'   => 'Permiso para pre-cotizar (Cotizaciónes)'
        ]);

        Permiso::create([
            'name'   => 'cotizar',
            'display_name'   => 'Cotizar',
            'description'   => 'Permiso para cotizar (Cotizaciónes)'
        ]);

        Permiso::create([
            'name'   => 'archivos',
            'display_name'   => 'Archivos',
            'description'   => 'Permiso para subir y/o modificar archivos'
        ]);

        Permiso::create([
            'name'   => 'graficas',
            'display_name'   => 'Gráficas',
            'description'   => 'Permiso para ver gráficas'
        ]);

        Permiso::create([
            'name'   => 'bitacora',
            'display_name'   => 'Bitácora',
            'description'   => 'Permiso para ver bitácora'
        ]);

        Permiso::create([
            'name'   => 'tiempos',
            'display_name'   => 'Tiempos',
            'description'   => 'Permiso para ver tiempos (Orden de producción)'
        ]);

        Permiso::create([
            'name'   => 'estados',
            'display_name'   => 'Estados',
            'description'   => 'Permiso para ver estados (Orden de producción)'
        ]);

        Permiso::create([
            'name'   => 'operario',
            'display_name'   => 'Operario',
            'description'   => 'Permiso para ver como operario (Orden de producción)'
        ]);

        Permiso::create([
            'name'   => 'importar',
            'display_name'   => 'Importar',
            'description'   => 'Permiso para importar archivos'
        ]);
    }
}
