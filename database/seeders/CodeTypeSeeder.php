<?php

namespace Database\Seeders;

use App\Models\Code_type;
use Exception;
use Illuminate\Database\Seeder;

class CodeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            //
        // $codetypes = array('code'=>"tsta",)

            //code type for todo status to be added
            Code_type::create([
                'code'=>strtoupper("tsta"),
                'description'=> "todo status"
            ]);

            //code type for countries to be added!!
            Code_type::create([
                'code'=>strtoupper("cou"),
                'description' => "country"
            ]);

        }catch(Exception $exception){
            echo $exception->getMessage();
        }

    }
}
