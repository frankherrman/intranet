<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitialDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('moneybird_customer_number')->nullable();
            $table->datetime('archived_at')->index()->nullable();
            $table->timestamps();
        });

        Schema::create('sla_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id', false, true);
            $table->float('hours', 6, 2)->index();
            $table->enum('hour_period', ['month', 'quarter', 'year']);
            $table->float('budget', 8, 2);
            $table->enum('invoice_period', ['month', 'quarter', 'year']);
            $table->date('start_date')->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::table('sla_contracts', function(Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
        });

        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ip_address');
            $table->string('mysql_url');
            $table->boolean('is_shared')->default(0);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id', false, true);
            $table->integer('server_id', false, true);
            $table->string('name');
            $table->integer('year');
            $table->string('url')->nullable();
            $table->integer('gitlab_id')->nullable();
            $table->timestamps();
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('server_id')->references('id')->on('servers');
        });

        Schema::create('project_sla_contracts', function (Blueprint $table) {
            $table->integer('project_id', false, true);
            $table->integer('sla_contract_id', false, true);
            $table->timestamps();
        });
        Schema::table('project_sla_contracts', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('sla_contract_id')->references('id')->on('sla_contracts');
        });

        Schema::create('sla_invoiced', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sla_contract_id', false, true);
            $table->date('invoice_date')->index();
            $table->date('end_date')->index();
            $table->integer('moneybird_id', false, true);
            $table->timestamps();
        });
        Schema::table('sla_invoiced', function (Blueprint $table) {
            $table->foreign('sla_contract_id')->references('id')->on('sla_contracts');
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        \DB::table('departments')->insert([
            ['name' => 'Marketing'],
            ['name' => 'Development'],
            ['name' => 'Creative'],
            ['name' => 'Management'],
            ['name' => 'Support']
        ]);

        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->integer('department_id', false, true);
            $table->boolean('available_monday_morning')->default(1)->index();
            $table->boolean('available_tuesday_morning')->default(1)->index();
            $table->boolean('available_wednesday_morning')->default(1)->index();
            $table->boolean('available_thursday_morning')->default(1)->index();
            $table->boolean('available_friday_morning')->default(1)->index();
            $table->boolean('available_monday_afternoon')->default(1)->index();
            $table->boolean('available_tuesday_afternoon')->default(1)->index();
            $table->boolean('available_wednesday_afternoon')->default(1)->index();
            $table->boolean('available_thursday_afternoon')->default(1)->index();
            $table->boolean('available_friday_afternoon')->default(1)->index();
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::create('users_projects', function (Blueprint $table) {
            $table->integer('user_id', false, true);
            $table->integer('project_id', false, true);
        });
        Schema::table('users_projects', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
        });

        Schema::create('hour_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id', false, true);
            $table->string('name');
            $table->timestamps();
        });
        Schema::table('hour_types', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments');
        });

        \DB::table('hour_types')->insert([
            ['department_id' => 1, 'name' => 'SEO'],
            ['department_id' => 1, 'name' => 'SEA'],
            ['department_id' => 1, 'name' => 'Content'],
            ['department_id' => 1, 'name' => 'Analyses'],
            ['department_id' => 1, 'name' => 'Other'],
            ['department_id' => 2, 'name' => 'Backend'],
            ['department_id' => 2, 'name' => 'Frontend'],
            ['department_id' => 2, 'name' => 'Mobile'],
            ['department_id' => 2, 'name' => 'Full stack'],
            ['department_id' => 2, 'name' => 'Testing'],
            ['department_id' => 2, 'name' => 'Other'],
            ['department_id' => 3, 'name' => 'UX'],
            ['department_id' => 3, 'name' => 'UI'],
            ['department_id' => 3, 'name' => 'Workshops'],
            ['department_id' => 3, 'name' => 'Testing'],
            ['department_id' => 3, 'name' => 'Other'],
            ['department_id' => 4, 'name' => 'Meeting'],
            ['department_id' => 4, 'name' => 'Planning/reporting'],
            ['department_id' => 4, 'name' => 'Project assistence'],
            ['department_id' => 4, 'name' => 'Client workshop'],
            ['department_id' => 4, 'name' => 'Other'],
            ['department_id' => 5, 'name' => 'Phonecall'],
            ['department_id' => 5, 'name' => 'Email'],
            ['department_id' => 5, 'name' => 'Issue'],
            ['department_id' => 5, 'name' => 'Change request'],
            ['department_id' => 5, 'name' => 'Other']
        ]);

        Schema::create('overhead_types', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        \DB::table('overhead_types')->insert([
            ['name' => 'Extended lunchbreak'],
            ['name' => 'Study'],
            ['name' => 'Doctor/Dentist visit'],
            ['name' => 'Coffee break'],
            ['name' => 'Table football'],
            ['name' => 'Other']
        ]);

        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id', false, true);
            $table->integer('department_id', false, true);
            $table->float('budget', 12, 2)->nullable();
            $table->boolean('fixed_price')->default(1);
            $table->boolean('exempt_from_sla')->default(1);
            $table->integer('invoiced')->default(0)->comment('Percentage invoiced');
            $table->timestamps();
        });
        Schema::table('activities', function(Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('department_id')->references('id')->on('departments');
        });

        Schema::create('hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->integer('hour_type_id', false, true)->nullable();
            $table->integer('activity_id', false, true)->nullable();
            $table->integer('overhead_type_id', false, true)->nullable();
            $table->date('date')->index();
            $table->float('hours', 6, 2);
            $table->boolean('billable')->default(1)->index();
            $table->string('description');
            $table->text('remarks')->nullable();
            $table->string('gitlab_ids')->nullable();
            $table->timestamps();
        });
        Schema::table('hours', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('hour_type_id')->references('id')->on('hour_types');
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('overhead_type_id')->references('id')->on('overhead_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
