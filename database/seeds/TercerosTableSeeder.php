<?php

use Illuminate\Database\Seeder;

use App\Models\Base\Tercero;

class TercerosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tercero::create(
            [
                'tercero_nit'   => 900387250,
                'tercero_tipo'   => 'NI',
                'tercero_regimen'   => 1,
                'tercero_persona'   => 2,
                'tercero_razonsocial'   => 'KOI Tecnologías de la Información S.A.S',
                'tercero_actividad'   => 204,
                'tercero_activo'   => true,
                'tercero_proveedor'   => true,
                'tercero_interno'   => true,
                'tercero_email'    => 'admin@koi-ti.com',
                'username'    => 'admin',
                'password' => '1280almas'
            ],
            [
                'tercero_nit'   => 1023878024,
                'tercero_tipo'   => 'CC',
                'tercero_regimen'   => 1,
                'tercero_persona'   => 1,
                'tercero_nombre1'   => 'Pedro',
                'tercero_nombre2'   => 'Antonio',
                'tercero_apellido1'   => 'Camargo',
                'tercero_apellido2'   => 'Jimenez',
                'tercero_actividad'   => 204,
                'tercero_activo'   => true,
                'tercero_interno'   => true,
                'tercero_email'    => 'dropecamargo@gmail.com',
                'username'    => 'dropecamargo',
                'password' => '1280almas'
            ]
        );
    }
}
