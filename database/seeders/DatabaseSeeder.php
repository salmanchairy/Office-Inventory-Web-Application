<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // ROLES
        // =========================

        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'Administrator sistem inventaris',
        ]);

        $petugasRole = Role::create([
            'name' => 'petugas',
            'description' => 'Petugas pemeriksaan inventaris',
        ]);

        // =========================
        // USER ADMIN
        // =========================

        User::create([
            'role_id' => $adminRole->id,
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@pelindo.co.id',
            'password' => Hash::make('admin123'),
            'status' => 'aktif',
        ]);

        // =========================
        // USER PETUGAS
        // =========================

        User::create([
            'role_id' => $petugasRole->id,
            'name' => 'Petugas Inventaris',
            'username' => 'petugas',
            'email' => 'petugas@pelindo.co.id',
            'password' => Hash::make('petugas123'),
            'status' => 'aktif',
        ]);

        // =========================
        // CATEGORIES
        // =========================

        $cpu = Category::create([
            'name' => 'CPU',
            'description' => 'Computer Processing Unit',
        ]);

        $monitor = Category::create([
            'name' => 'Monitor',
            'description' => 'Monitor komputer',
        ]);

        $printer = Category::create([
            'name' => 'Printer',
            'description' => 'Printer',
        ]);

        $ac = Category::create([
            'name' => 'AC',
            'description' => 'Air Conditioner',
        ]);

        // =========================
        // LOCATION
        // =========================

        $regional1 = Location::create([
            'regional' => 'Regional 1',
            'site' => 'Pelindo Regional 1',
            'building' => 'Gedung Utama',
            'room' => 'Server Room',
            'description' => 'Lokasi server room Regional 1',
        ]);

        // =========================
        // CONTOH ASSET
        // =========================

        Asset::create([
            'asset_code' => 'INV-R1-00057',
            'category_id' => $cpu->id,
            'location_id' => $regional1->id,
            'brand' => 'HP',
            'model' => 'CPU',
            'serial_number' => 'CNX7341K82',
            'condition' => 'Rusak Berat',
            'status' => 'Tidak Aktif',
            'description' => 'Data contoh dari inventaris manual',
            'created_by' => 1,
        ]);

        Asset::create([
            'asset_code' => 'INV-R1-00058',
            'category_id' => $cpu->id,
            'location_id' => $regional1->id,
            'brand' => 'ACER',
            'model' => 'M4 SERIES',
            'serial_number' => 'PSV769000390012992700',
            'condition' => 'Rusak Berat',
            'status' => 'Tidak Aktif',
            'description' => 'Data contoh dari inventaris manual',
            'created_by' => 1,
        ]);

        Asset::create([
            'asset_code' => 'INV-R1-00059',
            'category_id' => $monitor->id,
            'location_id' => $regional1->id,
            'brand' => 'LENOVO',
            'model' => 'Monitor',
            'serial_number' => 'V36D562',
            'condition' => 'Rusak Berat',
            'status' => 'Tidak Aktif',
            'description' => 'Data contoh dari inventaris manual',
            'created_by' => 1,
        ]);

        Asset::create([
            'asset_code' => 'INV-R1-00060',
            'category_id' => $monitor->id,
            'location_id' => $regional1->id,
            'brand' => 'ACER',
            'model' => 'Monitor',
            'serial_number' => '4005957885',
            'condition' => 'Rusak Berat',
            'status' => 'Tidak Aktif',
            'description' => 'Data contoh dari inventaris manual',
            'created_by' => 1,
        ]);

        Asset::create([
            'asset_code' => 'INV-R1-00062',
            'category_id' => $printer->id,
            'location_id' => $regional1->id,
            'brand' => 'CANNON',
            'model' => 'LBP 3050',
            'serial_number' => 'MAA4116062',
            'condition' => 'Rusak Berat',
            'status' => 'Tidak Aktif',
            'description' => 'Data contoh dari inventaris manual',
            'created_by' => 1,
        ]);
    }
}