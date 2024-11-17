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
        Schema::create('criteria_models', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->unique();
            $table->enum('type', ['benefit', 'cost']);
            $table->float('weight');
            $table->String('description', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_models');
    }
};
