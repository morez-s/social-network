<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // drop extra columns
            $table->dropColumn(['name']);

            // create new columns
            $table->string('username', 100)->after('id')->unique();
            $table->boolean('is_banned')->after('password')->default(false);
            $table->softDeletes();
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
            // drop newly created columns
            $table->dropSoftDeletes();
            $table->dropColumn(['username', 'is_banned']);

            // revert dropped columns
            $table->string('name')->after('id');
        });
    }
};
