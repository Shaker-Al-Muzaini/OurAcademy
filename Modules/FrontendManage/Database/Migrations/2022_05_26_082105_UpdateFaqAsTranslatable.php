<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class UpdateFaqAsTranslatable extends Migration
{

    public function up()
    {
        DB::statement('ALTER TABLE `home_page_faqs` CHANGE `question` `question` LONGTEXT  NULL DEFAULT NULL, CHANGE `answer` `answer` LONGTEXT NULL DEFAULT NULL;');

        $lang_code = 'en';
        $table_name = 'home_page_faqs';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->question, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'question' => '{"' . $lang_code . '":"' . $row->question . '"}',
                    'answer' => '{"' . $lang_code . '":"' . $row->answer . '"}',
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
