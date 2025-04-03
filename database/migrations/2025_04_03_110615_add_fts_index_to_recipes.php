<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE INDEX recipes_fts_idx ON recipes USING gin(to_tsvector(\'spanish\', title || \' \' || ingredients))');
        DB::statement('CREATE INDEX categories_fts_idx ON categories USING gin(to_tsvector(\'spanish\', name))');
        DB::statement('CREATE INDEX tags_fts_idx ON tags USING gin(to_tsvector(\'spanish\', name))');
        DB::statement('CREATE INDEX users_fts_idx ON users USING gin(to_tsvector(\'spanish\', name))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP INDEX IF EXISTS recipes_fts_idx');
        DB::statement('DROP INDEX IF EXISTS categories_fts_idx');
        DB::statement('DROP INDEX IF EXISTS tags_fts_idx');
        DB::statement('DROP INDEX IF EXISTS users_fts_idx');
    }
};