<?php

namespace Database\Seeders;

use App\Models\PlantillaPosition;
use App\Models\Position;
use Illuminate\Database\Seeder;

class PlantillaPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = Position::all()->keyBy('name');

        if ($positions->isEmpty()) {
            return;
        }

        $plantillas = [
            ['plantilla_number' => 'OSEC-DECSB-TCH1-310001-2021', 'position_id' => $positions['Teacher I']->id],
            ['plantilla_number' => 'OSEC-DECSB-TCH1-310002-2021', 'position_id' => $positions['Teacher I']->id],
            ['plantilla_number' => 'OSEC-DECSB-TCH1-310003-2021', 'position_id' => $positions['Teacher I']->id],
            ['plantilla_number' => 'OSEC-DECSB-TCH2-310004-2021', 'position_id' => $positions['Teacher II']->id],
            ['plantilla_number' => 'OSEC-DECSB-TCH2-310005-2021', 'position_id' => $positions['Teacher II']->id],
            ['plantilla_number' => 'OSEC-DECSB-TCH3-310006-2021', 'position_id' => $positions['Teacher III']->id],
            ['plantilla_number' => 'OSEC-DECSB-MTCH1-310007-2021', 'position_id' => $positions['Master Teacher I']->id],
            ['plantilla_number' => 'OSEC-DECSB-HTCH1-310008-2021', 'position_id' => $positions['Head Teacher I']->id],
            ['plantilla_number' => 'OSEC-DECSB-TCH1-310009-2024', 'position_id' => $positions['Teacher I']->id], // Intended for Vacant
            ['plantilla_number' => 'OSEC-DECSB-TCH2-310010-2024', 'position_id' => $positions['Teacher II']->id], // Intended for Vacant
        ];

        foreach ($plantillas as $plantilla) {
            PlantillaPosition::create($plantilla);
        }
    }
}
