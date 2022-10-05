<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlogTranslatabe extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE `blog_categories`
    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL;');

        $lang_code = 'en';
        $table_name = 'blog_categories';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $row->title . '"}'
                ]);
            }
        }


        DB::statement('ALTER TABLE `blogs`
    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL,
    CHANGE `description` `description` LONGTEXT NULL DEFAULT NULL;');

        $lang_code = 'en';
        $table_name = 'blogs';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $row->title . '"}',
                ]);
            }

            $pos = strpos($row->description, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'description' => '{"' . $lang_code . '":"' . $row->description . '"}',
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
