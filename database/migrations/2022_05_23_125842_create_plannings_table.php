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
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_school_id')->constrained('bus_schools')->onDelete('cascade');
            $table->string('monday_go_at');
            $table->string('monday_comeback_at');
            $table->string('tuesday_go_at');
            $table->string('tuesday_comeback_at');
            $table->string('wednesday_go_at');
            $table->string('wednesday_comeback_at');
            $table->string('thursday_go_at');
            $table->string('thursday_comeback_at');
            $table->string('friday_go_at');
            $table->string('friday_comeback_at');
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
        Schema::dropIfExists('plannings');
    }
};
