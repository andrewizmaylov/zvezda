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
        Schema::create('texts', function (Blueprint $table) {
	        $table->uuid('id')->primary();
	        $table->jsonb('schema')->nullable();
	        $table->char('user_id', 36)->nullable();
	        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
	        $table->char('textable_id', 36);
	        $table->string('textable_type');
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('texts');
    }
};
