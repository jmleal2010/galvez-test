<?php

namespace Database\Seeders;

use App\Models\Checklist;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Checklist::factory(20)->create();
    }
}
