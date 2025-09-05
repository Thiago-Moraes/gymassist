<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Academia;

class AcademiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Academia::create([
            'name' => 'Academia Principal',
            'address' => 'Rua Exemplo, 123',
            'city' => 'Cidade Exemplo',
            'state' => 'EX',
            'zip_code' => '12345-678',
        ]);
    }
}
