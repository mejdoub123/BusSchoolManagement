<?php

use Illuminate\Database\Migrations\Migration;
use MStaack\LaravelPostgis\Schema\Blueprint;
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
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_school_id')->constrained('bus_schools')->onDelete('cascade');
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->polygon('geom', 'GEOMETRY', 4326);
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
        Schema::dropIfExists('zones');
    }
};
