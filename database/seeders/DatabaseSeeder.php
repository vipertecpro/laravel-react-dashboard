<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BlogCategory;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookCategoryRelation;
use App\Models\BookTag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Dev Admin',
                'slug' => Str::slug('Dev Admin','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Admin',
                'slug' => Str::slug('Admin','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Customer',
                'slug' => Str::slug('Customer','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Staff Member',
                'slug' => Str::slug('Staff Member','__'),
                'guard_name' => 'web'
            ]
        ];
        DB::table('roles')->insert($roles);
        $permissions = [
            [
                'name' => 'Customers',
                'slug' => Str::slug('Customers','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Categories',
                'slug' => Str::slug('Categories','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Authors',
                'slug' => Str::slug('Authors','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Books',
                'slug' => Str::slug('Books','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Reviews',
                'slug' => Str::slug('Reviews','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Orders',
                'slug' => Str::slug('Orders','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Translations',
                'slug' => Str::slug('Translations','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Users',
                'slug' => Str::slug('Users','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Pages',
                'slug' => Str::slug('Pages','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Sections',
                'slug' => Str::slug('Sections','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Tags',
                'slug' => Str::slug('Tags','__'),
                'guard_name' => 'web'
            ],
            [
                'name' => 'Blogs',
                'slug' => Str::slug('Blogs','__'),
                'guard_name' => 'web'
            ]
        ];
        DB::table('permissions')->insert($permissions);
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('123456'),
            'created_by' => 0
        ]);
        $user->syncRoles(['Dev Admin']);
        User::factory(10)->create();
        BookCategory::factory(10)->create();
        BookTag::factory(10)->create();
        Book::factory(10)->create();
        BookCategoryRelation::factory(10)->create();
        BlogCategory::factory(10)->create();
    }
}
