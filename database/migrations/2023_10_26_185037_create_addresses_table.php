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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->string('zip')->nullable();
			$table->string('country')->nullable();
			$table->string('city')->nullable();
			$table->string('street_01')->nullable();
			$table->string('street_02')->nullable();
			$table->char('addressable_id', 36);
			$table->string('addressable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
