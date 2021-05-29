<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spend;
class SpendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spend::factory()->time(500)->create();
    }
}
