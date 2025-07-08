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
        Schema::create('dynamic_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });
        Schema::create('dynamic_columns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dynamic_table_id')->constrained('dynamic_tables')->onDelete('cascade');
            $table->string('column_name');
            $table->string('column_slug');
            $table->string('column_type');
            $table->json('validation_rules')->nullable();
            $table->timestamps();
        });
        Schema::create('dynamic_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dynamic_table_id')->constrained('dynamic_tables')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('dynamic_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dynamic_row_id')->constrained('dynamic_rows')->onDelete('cascade');
            $table->foreignId('dynamic_column_id')->constrained('dynamic_columns')->onDelete('cascade');
            $table->longText('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_values');
        Schema::dropIfExists('dynamic_rows');
        Schema::dropIfExists('dynamic_columns');
        Schema::dropIfExists('dynamic_tables');
    }
};
