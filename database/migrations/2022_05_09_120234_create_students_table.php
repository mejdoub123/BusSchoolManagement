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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('bus_school_id')->nullable()->constrained('bus_schools')->onDelete('cascade');
            $table->foreignId('zone_id')->nullable()->constrained('zones')->onDelete('cascade');
            $table->string('cne', 20);
            $table->string('address');
            $table->string('phone_number');
            $table->point('current_position', 'GEOMETRY', 4326)->nullable();
            $table->point('address_position', 'GEOMETRY', 4326);
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
        Schema::dropIfExists('students');
    }
};
