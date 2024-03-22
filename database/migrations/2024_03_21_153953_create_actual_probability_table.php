<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('actual_probability', function (Blueprint $table) {
            $table->id();
            $table->string('number_of_prize', 10, 2)->default(0);
            $table->longText('labels');
            $table->longText('probabilities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actual_probability');
    }
};
