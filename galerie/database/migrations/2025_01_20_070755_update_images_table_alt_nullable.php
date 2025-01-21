<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('alt')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('alt')->nullable(false)->change();
        });
    }
};
