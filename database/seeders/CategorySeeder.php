<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $categories = [
            'Livelihood',
            'Food',
            'Health',
            'Water & Environment',
            'Energy',
            'Transportation',
            'Climate and Disaster Resilience',
            'Digital Transformation',
        ];

        $rows = [];
        foreach ($categories as $name) {
            $slug = Str::slug($name);
            $rows[] = [
                'name'       => $name,
                'slug'       => $slug,
                'image'      => $slug . '.png',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert or update existing rows by 'slug'
        DB::table('categories')
            ->upsert(
                $rows,
                ['slug'],              // unique key to check
                ['name', 'image', 'updated_at']  // columns to update if exists
            );
    }
}
