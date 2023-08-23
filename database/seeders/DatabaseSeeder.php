<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\BookReview;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => Str::slug('Admin','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Customer',
                'slug' => Str::slug('Customer','__'),
                'guard_name' => 'web'
            ]
        ];
        DB::table('roles')->insert($roles);
        $permissions = [
            [
                'name' => 'Create Book',
                'slug' => Str::slug('Create Book','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Edit Book',
                'slug' => Str::slug('Edit Book','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Delete Book',
                'slug' => Str::slug('Delete Book','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Create Book Review',
                'slug' => Str::slug('Create Book Review','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Edit Book Review',
                'slug' => Str::slug('Create Book Review','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Delete Book Review',
                'slug' => Str::slug('Delete Book Review','__'),
                'guard_name' => 'web'
            ]
        ];
        DB::table('permissions')->insert($permissions);
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
        ]);
        $user->syncRoles(['Admin']);
        $user = User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@customer.com',
            'password' => Hash::make('123456'),
        ]);
        $user->syncRoles(['Customer']);
        User::factory(10)->create()->each(function ($user) {
            $user->syncRoles(['Customer']);
            $books = Book::factory(rand(2, 5))->create(['created_by' => $user->id]);
            $books->each(function ($book) use ($user) {
                BookReview::factory(rand(5, 10))->create([
                    'created_by' => $user->id,
                    'book_id' => $book->id
                ]);
            });
        });
    }
}
