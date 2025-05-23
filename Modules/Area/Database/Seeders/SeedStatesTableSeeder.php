<?php

namespace Modules\Area\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Area\Entities\State;

class SeedStatesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($states, $city)
    {
        $state = State::create(['status' => 1, 'city_id' => $city->id]);


        $state->translateOrNew('en')->title = $states['en'];
        $state->translateOrNew('ar')->title = $states['ar'];
        $state->translateOrNew('en')->slug = slugfy($states['en']);
        $state->translateOrNew('ar')->slug = slugfy($states['ar']);
        $state->save();
    }
}
