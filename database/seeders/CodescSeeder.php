<?php

namespace Database\Seeders;

use App\Models\Code_type;
use App\Models\Codesc;
use Exception;
use Illuminate\Database\Seeder;

class CodescSeeder extends Seeder
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
            $todoStatusCodeTypeId = Code_type::where('code', 'tsta')->value('id');

            Codesc::create([
                'code_type_id' => $todoStatusCodeTypeId,
                'code' => strtolower("nts"),
                'description' => strtolower("not started")
            ]);

            Codesc::create([
                'code_type_id' => $todoStatusCodeTypeId,
                'code' => strtolower("wip"),
                'description' => strtolower("work in progress")
            ]);

            Codesc::create(['code_type_id'=>$todoStatusCodeTypeId,
                            'code'=>strtolower("cmp"),
                            'description'=>strtolower("completed")
            ]);

        }catch(Exception $exception){
            echo ($exception->getMessage());
        }
    }
}
