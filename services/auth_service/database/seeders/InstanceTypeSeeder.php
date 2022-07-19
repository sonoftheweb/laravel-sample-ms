<?php

namespace Database\Seeders;

use App\Models\InstanceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class InstanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $json = File::get(base_path("database/data/instance_types.json"));
		foreach (json_decode($json, true) as $item) {
			InstanceType::query()->create($item);
		}
    }
}
