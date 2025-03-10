<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Název alba
            $table->text('description')->nullable(); // Popis alba (volitelné)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('albums');
    }
};
