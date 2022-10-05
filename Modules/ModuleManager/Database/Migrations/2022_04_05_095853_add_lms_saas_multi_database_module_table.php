<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Entities\Module;

class AddLmsSaasMultiDatabaseModuleTable extends Migration
{

    public function up()
    {
        $totalCount = DB::table('modules')->count();
        $newModule = new Module();
        $newModule->name = 'LmsSaasMD';
        $newModule->details = 'LmsSaas Multi Database Module For InfixLMS. ';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }


}
