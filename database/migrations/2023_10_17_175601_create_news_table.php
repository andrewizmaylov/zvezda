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
        Schema::create('news', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->string('name');
			$table->string('slug')->nullable();
			$table->text('description')->nullable();
	        $table->jsonb('details')->nullable();
	        $table->timestamp('published_at')->nullable();

	        $table->string('image')->nullable();

	        $table->jsonb('schema')->nullable();
	        $table->char('user_id', 36)->nullable();
	        $table->char('team_id', 36)->nullable();
			$table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
			$table->foreign('team_id')->references('id')->on('teams')->nullOnDelete();
	        $table->softDeletes();
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
