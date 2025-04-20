<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role
        $roleAdmin = Role::updateOrCreate(['name' => 'Admin']);
        $roleUser  = Role::updateOrCreate(['name' => 'User']);

        // Buat permission
        $permissions = [
            'view_admin', 'view_user', 'dashboard',
            'category_create', 'category_read', 'category_update', 'category_delete',
            'event_create', 'event_read', 'event_update', 'event_delete',
            'ticket_create', 'ticket_read', 'ticket_update', 'ticket_delete',
            'pembayaran_read', 'pembayaran_update', 'pembayaran_process',
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['name' => $perm]);
        }

        // Buat user admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );

        // Buat user biasa
        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name'     => 'sample user',
                'password' => Hash::make('12345678'),
            ]
        );

        // Beri Admin semua permission
        $roleAdmin->givePermissionTo(Permission::all());

        // Beri User hanya akses CRUD kategori, event, tiket, dan dashboard
        $roleUser->givePermissionTo([
            'dashboard',
            'category_create', 'category_read', 'category_update', 'category_delete',
            'event_create', 'event_read', 'event_update', 'event_delete',
            'ticket_create', 'ticket_read', 'ticket_update', 'ticket_delete',
        ]);

        // Assign role ke user
        $admin->assignRole('Admin');
        $user->assignRole('User');
    }
}
