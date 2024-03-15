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
        Schema::create('post_slide_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_slide_id')->constrained();
            $table->foreignId('tagged_user_id')->constrained('users');
            $table->decimal('flag_horizontal_position', 10, 2)->default(0);
            $table->decimal('flag_vertical_position', 10, 2)->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('post_slide_tags');
    }
};
