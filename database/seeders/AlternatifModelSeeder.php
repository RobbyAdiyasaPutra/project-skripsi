<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AlternatifModel;

class AlternatifModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // make a 10 data alternatif seeder without factory and fill diferent name
        $alternatifData = [
            ['name' => 'Alternatif 1'],
            ['name' => 'Alternatif 2'],
            ['name' => 'Alternatif 3'],
            ['name' => 'Alternatif 4'],
            ['name' => 'Alternatif 5'],
        ];

        foreach ($alternatifData as $data) {
            AlternatifModel::create($data);
        }



    }
}
