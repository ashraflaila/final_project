<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $countries = [
            ['name' => 'Saudi Arabia',    'code' => 'SA'],
            ['name' => 'Egypt',           'code' => 'EG'],
            ['name' => 'United Arab Emirates', 'code' => 'AE'],
            ['name' => 'Kuwait',          'code' => 'KW'],
            ['name' => 'Qatar',           'code' => 'QA'],
            ['name' => 'Bahrain',         'code' => 'BH'],
            ['name' => 'Oman',            'code' => 'OM'],
            ['name' => 'Jordan',          'code' => 'JO'],
            ['name' => 'Lebanon',         'code' => 'LB'],
            ['name' => 'Syria',           'code' => 'SY'],
            ['name' => 'Iraq',            'code' => 'IQ'],
            ['name' => 'Yemen',           'code' => 'YE'],
            ['name' => 'Libya',           'code' => 'LY'],
            ['name' => 'Tunisia',         'code' => 'TN'],
            ['name' => 'Algeria',         'code' => 'DZ'],
            ['name' => 'Morocco',         'code' => 'MA'],
            ['name' => 'Sudan',           'code' => 'SD'],
            ['name' => 'Somalia',         'code' => 'SO'],
            ['name' => 'Mauritania',      'code' => 'MR'],
            ['name' => 'Palestine',       'code' => 'PS'],
            ['name' => 'United States',   'code' => 'US'],
            ['name' => 'United Kingdom',  'code' => 'GB'],
            ['name' => 'Germany',         'code' => 'DE'],
            ['name' => 'France',          'code' => 'FR'],
            ['name' => 'Italy',           'code' => 'IT'],
            ['name' => 'Spain',           'code' => 'ES'],
            ['name' => 'Turkey',          'code' => 'TR'],
            ['name' => 'Russia',          'code' => 'RU'],
            ['name' => 'China',           'code' => 'CN'],
            ['name' => 'Japan',           'code' => 'JP'],
            ['name' => 'India',           'code' => 'IN'],
            ['name' => 'Pakistan',        'code' => 'PK'],
            ['name' => 'Bangladesh',      'code' => 'BD'],
            ['name' => 'Indonesia',       'code' => 'ID'],
            ['name' => 'Malaysia',        'code' => 'MY'],
            ['name' => 'Nigeria',         'code' => 'NG'],
            ['name' => 'South Africa',    'code' => 'ZA'],
            ['name' => 'Kenya',           'code' => 'KE'],
            ['name' => 'Ethiopia',        'code' => 'ET'],
            ['name' => 'Ghana',           'code' => 'GH'],
            ['name' => 'Brazil',          'code' => 'BR'],
            ['name' => 'Argentina',       'code' => 'AR'],
            ['name' => 'Mexico',          'code' => 'MX'],
            ['name' => 'Canada',          'code' => 'CA'],
            ['name' => 'Australia',       'code' => 'AU'],
            ['name' => 'Netherlands',     'code' => 'NL'],
            ['name' => 'Belgium',         'code' => 'BE'],
            ['name' => 'Sweden',          'code' => 'SE'],
            ['name' => 'Switzerland',     'code' => 'CH'],
            ['name' => 'Portugal',        'code' => 'PT'],
        ];

        $data = array_map(fn($c) => array_merge($c, [
            'created_at' => $now,
            'updated_at' => $now,
        ]), $countries);

        DB::table('countries')->insert($data);
    }
}
