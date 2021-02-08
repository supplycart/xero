<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsInternalAndCountryColumnToXerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xeros', function (Blueprint $table) {
            $table->boolean('is_internal')->after('is_enabled')->default(false);
            $table->string('tenant_name')->after('is_internal')->nullable();
            $table->string('country', 35)->after('tenant_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('xeros', function (Blueprint $table) {
            $table->dropColumn('is_internal');
            $table->dropColumn('country');
            $table->dropColumn('tenant_name');
        });
    }
}
