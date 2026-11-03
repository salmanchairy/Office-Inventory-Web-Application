<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->string('asset_code', 50)->unique();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('location_id')
                ->constrained('locations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('brand', 100);
            $table->string('model', 100)->nullable();
            $table->string('serial_number', 150)->nullable();

            $table->date('purchase_date')->nullable();
            $table->year('acquisition_year')->nullable();

            $table->enum('condition', [
                'Baik',
                'Rusak Ringan',
                'Rusak Berat'
            ])->default('Baik');

            $table->enum('status', [
                'Aktif',
                'Dipinjam',
                'Dipindahkan',
                'Diperbaiki',
                'Tidak Aktif',
                'Dihapus'
            ])->default('Aktif');

            $table->text('description')->nullable();
            $table->string('photo')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};