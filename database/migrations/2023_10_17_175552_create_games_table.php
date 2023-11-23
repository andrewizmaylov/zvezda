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
        Schema::create('games', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->string('name')->nullable();
			$table->string('slug')->nullable();
	        $table->text('description')->nullable();
	        $table->jsonb('details')->nullable();
	        $table->timestamp('published_at')->nullable();

	        $table->string('image')->nullable();

	        $table->date('date')->nullable();
	        $table->time('time')->nullable();
	        $table->char('team_a', 36)->nullable();
	        $table->char('team_b', 36)->nullable();
	        $table->char('stadium_id', 36)->nullable();
			$table->foreign('team_a')->references('id')->on('teams')->nullOnDelete();
			$table->foreign('team_b')->references('id')->on('teams')->nullOnDelete();
			$table->foreign('stadium_id')->references('id')->on('stadia')->nullOnDelete();

	        $table->softDeletes();
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
