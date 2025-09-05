<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Filial;
use App\Models\Academia;

class FilialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Certifique-se de que existe pelo menos uma academia
        $academia = Academia::first();

        if (!$academia) {
            // Se não houver academia, crie uma (ou chame o seeder de academias)
            $this->call(AcademiaSeeder::class);
            $academia = Academia::first();
        }

        Filial::create([
            'academia_id' => $academia->id,
            'name' => 'Filial Principal',
            'address' => 'Rua da Filial, 456',
            'city' => 'Cidade Exemplo',
            'state' => 'EX',
            'zip_code' => '87654-321',
        ]);
    }
}
