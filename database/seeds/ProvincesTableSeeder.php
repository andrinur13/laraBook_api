<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $url_provinces = 'https://api.rajaongkir.com/starter/province?key=ffae86b34880d108cba572a5d84088f2';
        $json_str = file_get_contents($url_provinces);
        $json_obj = json_decode($json_str);

        $provinces = [];

        foreach($json_obj->rajaongkir->results as $province) {
            $provinces[] = [
                'id' => $province->province_id,
                'provinces' => $province->province
            ];
        }

        DB::table('provinces')->insert($provinces);
    }
}
