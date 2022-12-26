<?php

namespace Database\Seeders;

use App\Models\Code_type;
use App\Models\Codesc;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        try{
            $responses = Http::get('https://restcountries.com/v2/all');
            $countries = json_decode($responses);
            $countriesArray = array();


            // return $countryCodeTypeId;

            //store them here
            $addedCountries = array();

            //get the country character code and its name and store in the countries array
            foreach ($countries as $country){
                $countriesArray = $this->array_push_assoc($countriesArray, $country->alpha3Code, $country->name);

                //get the countries code type id
                // $countryCodeTypeId = DB::table('code_types')->where('code', 'COU')->value('id');
                $countryCodeTypeId = Code_type::where('code','COU')->value('id');

                Codesc::create([
                    'code_type_id'=>$countryCodeTypeId,
                    'code'=>$country->alpha3Code,
                    'description'=>$country->name
                ]);
            }

        }catch(Exception $exception){
            echo $exception->getMessage();
        }
    }

    //method to push associately into an array
    function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
     }
}
