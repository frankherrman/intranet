<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->index();
            $table->timestamps();
        });
        Schema::create('users_permissions', function(Blueprint $table) {
            $table->integer('user_id', false, true);
            $table->string('permission_key', false, true);
            $table->timestamps();
        });
        Schema::table('users_permissions', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('permission_key')->references('key')->on('permissions');
        });

        \DB::table('permissions')->insert([
            ['key' => 'ADMIN'],
            ['key' => 'MANAGE_CLIENT'],
            ['key' => 'MANAGE_SLA'],
            ['key' => 'MANAGE_PROJECTS'],
            ['key' => 'MANAGE_ACTIVITIES'],
            ['key' => 'TIMEMANAGEMENT'],
            ['key' => 'REPORTING'],
            ['key' => 'HR'],
            ['key' => 'INVOICING'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
