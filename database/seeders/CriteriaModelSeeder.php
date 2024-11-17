<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CriteriaModel;

class CriteriaModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // make a 10 data criteria seeder without factory and fill diferent all
        $criteriaData = [
            ['code' => 'C1',  'type' => 'benefit', 'weight' => 3, 'description' => 'Kriteria 1'],
            ['code' => 'C2',  'type' => 'benefit', 'weight' => 2, 'description' => 'Kriteria 2'],
            ['code' => 'C3',  'type' => 'benefit', 'weight' => 1, 'description' => 'Kriteria 3'],
            ['code' => 'C4',  'type' => 'benefit', 'weight' => 2, 'description' => 'Kriteria 4'],
            ['code' => 'C5',  'type' => 'benefit', 'weight' => 2, 'description' => 'Kriteria 5'],
        ];

        foreach ($criteriaData as $data) {
            CriteriaModel::create($data);
        }


    }
}
