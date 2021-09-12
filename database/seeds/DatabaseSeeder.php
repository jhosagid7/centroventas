<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(JhosagidPermissionInfoSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(SucursalSeeder::class);
        $this->call(TasaSeeder::class);
        $this->call(DenominacionSeeder::class);
        $this->call(PersonaSeeder::class);
    }
}
