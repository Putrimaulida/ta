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
        Schema::create('pantai_jenis_mangrove', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pantai_id');
            $table->foreign('pantai_id')->references('id')->on('pantais')->onDelete('cascade');
            $table->unsignedBigInteger('jenis_mangrove_id');
            $table->foreign('jenis_mangrove_id')->references('id')->on('jenis_mangroves')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pantai_jenis_mangrove');
    }
};
