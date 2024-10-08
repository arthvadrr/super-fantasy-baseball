<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('team_id')
                ->nullable()
                ->constrained('teams');
            $table->string('full_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('age');
            $table->string('position');
            $table->unsignedInteger('rating_arm');
            $table->unsignedInteger('rating_speed');
            $table->unsignedInteger('rating_hitting');
            $table->unsignedInteger('rating_fielding');
            $table->unsignedInteger('rating_pitching')->nullable();
            $table->json('pitches')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
