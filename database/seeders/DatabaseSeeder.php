<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\UpsellCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
        ]);
        UpsellCategory::create([
            'name' => 'Keresőoptimalizálás',
        ]);
        UpsellCategory::create([
            'name' => 'AI projekt integráció',
        ]);
        UpsellCategory::create([
            'name' => 'Hírlevél marketing',
        ]);
        UpsellCategory::create([
            'name' => 'Közösségi média',
        ]);
        UpsellCategory::create([
            'name' => 'Weboldal nyelviesítés',
        ]);
        UpsellCategory::create([
            'name' => 'Blog írás',
        ]);
        UpsellCategory::create([
            'name' => 'Online hirdetések',
        ]);
        UpsellCategory::create([
            'name' => 'Webanalitika beállítása',
        ]);
        UpsellCategory::create([
            'name' => 'Webshop',
        ]);
        UpsellCategory::create([
            'name' => 'Egyedi fejlesztések',
        ]);

    }
}
