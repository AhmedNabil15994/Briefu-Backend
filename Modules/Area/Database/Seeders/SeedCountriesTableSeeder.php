<?php

namespace Modules\Area\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Area\Entities\Country;

class SeedCountriesTableSeeder extends Seeder
{
    private $records = [
        "Kuwait" => "الكويت",
        "Algeria" => " الجزائر",
        "Bahrain" => " ‫البحرين‬‎",
        "Comoros" => " ‫جزر القمر‬‎",
        "Egypt" => " ‫مصر‬‎",
        "Iran" => " ‫ایران‬‎",
        "Iraq" => " ‫العراق‬‎",
        "Jordan" => " ‫الأردن‬‎",
        "Lebanon" => " ‫لبنان‬‎",
        "Libya" => " ‫ليبيا‬‎",
        "Mauritania" => " ‫موريتانيا‬‎",
        "Morocco" => " ‫المغرب‬‎",
        "Oman" => " ‫عُمان‬‎",
        "Pakistan" => " ‫پاکستان‬‎",
        "Palestine" => " ‫فلسطين‬‎",
        "Qatar" => " ‫قطر‬‎",
        "Saudi Arabia" => " ‫المملكة العربية السعودية‬‎",
        "South Sudan" => " ‫جنوب السودان‬‎",
        "Sudan" => " ‫السودان‬‎",
        "Syria" => " ‫سوريا‬‎",
        "Tunisia" => " ‫تونس‬‎",
        "United Arab Emirates" => " ‫الإمارات العربية المتحدة‬‎",
        "Western Sahara" => " ‫الصحراء الغربية‬‎",
        "Yemen" => " ‫اليمن‬‎",
        "Afghanistan" => " ‫افغانستان‬‎",
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->records as $en => $ar) {
            $model = Country::create(['status' => 1]);

            $model->translateOrNew('en')->title = $en;
            $model->translateOrNew('ar')->title = $ar;
            $model->translateOrNew('en')->slug = slugfy($en);
            $model->translateOrNew('ar')->slug = slugfy($ar);
        }
    }
}
