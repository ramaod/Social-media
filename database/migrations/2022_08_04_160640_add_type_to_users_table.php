<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::table('users', function($table) {
                $table->string('type')->nullable()->after('password');
            });
        });
        Schema::table('posts', function (Blueprint $table) {
            Schema::table('posts', function($table) {
                $table->string('type')->nullable()->after('text');
            });
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
            $table->dropColumn('type');
        }); 
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('type');
        }); 
    }
}
