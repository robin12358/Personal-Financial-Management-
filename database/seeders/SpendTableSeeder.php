<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spend;
class SpendTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spend::factory()->times(10000)->create();
    }
}
