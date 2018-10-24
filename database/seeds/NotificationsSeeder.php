<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Notificacion;
use Faker\Factory as Faker;

class NotificationsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 15; $i++) {
            Notificacion::create([
                'notificacion_tercero' => 380,
                'notificacion_titulo' => $faker->title,
                'notificacion_descripcion' => $faker->text,
                'notificacion_fh' => $faker->dateTime,
            ]);
        }

        for ($i=0; $i < 5; $i++) {
            Notificacion::create([
                'notificacion_tercero' => 302,
                'notificacion_titulo' => $faker->title,
                'notificacion_descripcion' => $faker->text,
                'notificacion_fh' => $faker->dateTime,
            ]);
        }
    }
}
