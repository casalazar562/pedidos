<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cuenta;
use App\Models\Pedido;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cuenta::factory()->count(3)->create();
        Pedido::factory()->count(1)->create([
            'product'=>'Cafe',
            'amount'=>2,
            'value'=>2000,
            'total'=>4000,
        ]);
        Pedido::factory()->count(1)->create([
            'product'=>'torta',
            'amount'=>2,
            'value'=>3000,
            'total'=>6000,
        ]);
    }
}
