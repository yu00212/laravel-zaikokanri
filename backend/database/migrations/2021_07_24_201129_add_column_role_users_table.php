<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRoleUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //roleカラムをTINYINT型でpasswordカラムの後に追加。更にインデックスを付与。
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('role')->default(0)->after('password')->index('index_role')->comment('ロール');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
