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
        Schema::create('data_lapangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pantai_id');
            $table->integer('tahun');
            $table->double('luasan');
            $table->timestamps();
            $table->foreign('pantai_id')->references('id')->on('pantais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_lapangs');
    }
};
