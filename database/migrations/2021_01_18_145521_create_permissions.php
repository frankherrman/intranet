<?php

use App\Models\Permission;
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
            $table->increments('id');
            $table->string('key')->index();
            $table->timestamps();
        });
        Schema::create('permission_user', function(Blueprint $table) {
            $table->integer('user_id', false, true);
            $table->integer('permission_id', false, true);
            $table->timestamps();
        });
        Schema::table('permission_user', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });

        \DB::table('permissions')->insert([
            ['key' => 'ADMIN'],
            ['key' => 'MANAGE_CLIENTS'],
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
