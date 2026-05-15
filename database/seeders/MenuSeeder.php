<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programMenu = Menu::updateOrCreate(
            ['name' => 'Program', 'parent_id' => null, 'role' => 'merchant'],
            [
                'route' => null,
                'icon' => 'fas fa-th-large',
                'order' => 1,
                'is_active' => true,
            ]
        );

        Menu::updateOrCreate(
            ['name' => 'Categories', 'parent_id' => $programMenu->id, 'role' => 'merchant'],
            [
                'route' => 'categories.index',
                'icon' => 'fas fa-circle',
                'order' => 1,
                'is_active' => true,
            ]
        );

        Menu::updateOrCreate(
            ['name' => 'Products', 'parent_id' => $programMenu->id, 'role' => 'merchant'],
            [
                'route' => 'products.index',
                'icon' => 'fas fa-circle',
                'order' => 2,
                'is_active' => true,
            ]
        );

        $reportMenu = Menu::updateOrCreate(
            ['name' => 'Report', 'parent_id' => null, 'role' => 'merchant'],
            [
                'route' => null,
                'icon' => 'fas fa-file-alt',
                'order' => 2,
                'is_active' => true,
            ]
        );

        Menu::updateOrCreate(
            ['name' => 'Cetak Laporan', 'parent_id' => $reportMenu->id, 'role' => 'merchant'],
            [
                'route' => null,
                'icon' => 'fas fa-circle',
                'order' => 1,
                'is_active' => true,
            ]
        );
    }
}
