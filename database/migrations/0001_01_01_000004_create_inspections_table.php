<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->dateTime('inspection_date');

            $table->enum('condition', [
                'Baik',
                'Rusak Ringan',
                'Rusak Berat'
            ]);

            $table->string('serial_number_checked', 150)->nullable();

            $table->enum('physical_check', [
                'Sesuai',
                'Tidak Sesuai'
            ])->default('Sesuai');

            $table->text('description')->nullable();
            $table->text('recommendation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};