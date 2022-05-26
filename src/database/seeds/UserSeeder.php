<?php namespace Database\Seeders;


use App\Models\User;
use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Yo';
        $user->email = 'admin@tcell.tj';
        $user->password =bcrypt('secret');
        $user->save();

        $adminRole = new Role();
        $adminRole->name = 'admin';
        $adminRole->save();

        $moderatorRole = new Role();
        $moderatorRole->name = 'moderator';
        $moderatorRole->save();

        $merchantRole = new Role();
        $merchantRole->name = 'merchant';
        $merchantRole->save();

        $deliveryRole = new Role();
        $deliveryRole->name = 'delivery';
        $deliveryRole->save();

        $permissions = [
            'view_users',
            'edit_users',
            'delete_users',
            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',
            'view_products',
            'add_products',
            'edit_products',
            'delete_products',
            'view_shop_products',
            'view_my_shops',
            'view_shops',
            'edit_shops',
            'add_shops',
            'status_pending_products',
            'status_active_products',
            'status_denied_products',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole->syncPermissions($permissions);
        $user->assignRole('admin');
    }
}
