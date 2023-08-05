<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'name_ar'    =>'أفغانستان',
                'name_en' =>'Afghanistan',
                'code'    =>'AF',
                'spoken_language'=>'ar',
                'country_code'    =>'+93',
                'status'    =>'UNACTIVE',
                'message'    =>'Sorry This Ip Is Forrbiden',
            ],
            [
                'name_ar'    =>'الأرجنتين',
                'name_en' =>'Argentina',
                'code'    =>'AR',
                'spoken_language'=>'En',
                'country_code'    =>'+54',
                'status'    =>'UNACTIVE',
                'message'    =>'Sorry This Ip Is Forrbiden',
            ],

            [
                'name_ar'    =>'مصر',
                'name_en' =>'Egypt',
                'code'    =>'EG',
                'spoken_language'=>'ar',
                'country_code'    =>'+20',
                'status'    =>'UNACTIVE',
                'message'    =>'Sorry This Ip Is Forrbiden',
            ],

            [
                'name_ar'    =>'سوريا',
                'name_en' =>'Syria',
                'code'    =>'SY',
                'spoken_language'=>'ar',
                'country_code'    =>'+963',
                'status'    =>'UNACTIVE',
                'message'    =>'Sorry This Ip Is Forrbiden',
            ],


            [
                'name_ar'    =>'الولايات المتحدة',
                'name_en' =>'United State',
                'code'    =>'US',
                'spoken_language'=>'En',
                'country_code'    =>'+1',
                'status'    =>'UNACTIVE',
                'message'    =>'Sorry This Ip Is Forrbiden',
            ],


            [
                'name_ar'    =>'الإمارات العربية المتحدة',
                'name_en' =>'United Arab Emirates',
                'code'    =>'AE',
                'spoken_language'=>'ar',
                'country_code'    =>'+1',
                'status'    =>'UNACTIVE',
                'message'    =>'Sorry This Ip Is Forrbiden',
            ],
            
            ];

        Country::insert($data);
    }
}
