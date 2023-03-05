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
        Schema::create('washers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('smartthings_id');
            $table->string('state')->default('stop');
            $table->string('jobState')->default('none');
            $table->timestamp('start')->useCurrent();
            $table->timestamp('end')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('washers');
    }
};
