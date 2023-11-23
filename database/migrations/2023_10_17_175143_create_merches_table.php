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
        Schema::create('merches', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->string('name');
			$table->string('slug')->nullable();
			$table->text('description')->nullable();
			$table->jsonb('details')->nullable();
			$table->timestamp('published_at')->nullable();
	        $table->string('image')->nullable();
	        $table->softDeletes();
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merches');
    }
};
