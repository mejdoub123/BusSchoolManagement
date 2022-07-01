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
        Schema::create('bus_schools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->integer('capacity');
            $table->point('current_position', 'GEOMETRY', 4326)->nullable();
            $table->string('matricule');
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
        Schema::dropIfExists('bus_schools');
    }
};
