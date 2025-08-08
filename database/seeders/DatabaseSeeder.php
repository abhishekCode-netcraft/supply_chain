<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Delete table daeta before overriding.
        Role::query()->delete();
        Permission::query()->delete();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();


        $adminRole = Role::create(['name' => 'Super Admin']);
        $writerRole = Role::create(['name' => 'Writer']);
        $writerRole = Role::create(['name' => 'Developer']);

        // Permissions Seeder

        // Permission::create(['name' => 'Role create']);
        // Permission::create(['name' => 'User Details (Main Menu)']);
        // Permission::create(['name' => 'Allot User Roles']);
        // Permission::create(['name' => 'User Details -> All Users List -> Edit']);
        // Permission::create(['name' => 'User New create']);
        // Permission::create(['name' => 'User delete']);
        // Permission::create(['name' => 'Roles & Permissions (Main Menu)']);
        // Permission::create(['name' => 'Roles & Permissions -> Assign Permissions to Roles']);
        // Permission::create(['name' => 'Roles & Permissions -> View All Roles & Permissions']);
        // Permission::create(['name' => 'Roles & Permissions -> Assign Permissions to Roles -> Edit']);
        // Permission::create(['name' => 'Roles & Permissions -> Assign Permissions to Roles -> Create']);
        // Permission::create(['name' => 'Roles & Permissions -> Assign Permissions to Roles -> Delete']);
        // Permission::create(['name' => 'Listing (Main Menu)']);
        // Permission::create(['name' => 'Listing Create (M/S)']);
        // Permission::create(['name' => 'Listing create ( DB )']);
        // Permission::create(['name' => 'RA-Pending Listing (DB)']);
        // Permission::create(['name' => 'Listing Create (M/S) -> Publish to Website']);
        // Permission::create(['name' => 'Image Creation (Main Menu)']);
        // Permission::create(['name' => 'Image Creation -> Single Image Maker']);
        // Permission::create(['name' => 'Image Creation -> Combo Image Maker']);
        // Permission::create(['name' => 'Image Creation -> Gallery ( DB )']);
        // Permission::create(['name' => 'Inventory (Main Menu)']);
        // Permission::create(['name' => 'Inventory -> Manage Inventory']);
        // Permission::create(['name' => 'Inventory -> Drafted Inventory']);
        // Permission::create(['name' => 'Inventory -> Under Review Inventory']);
        // Permission::create(['name' => 'Inventory -> Manage Inventory -> Edit']);
        // Permission::create(['name' => 'Inventory -> Manage Inventory -> Delete']);
        // Permission::create(['name' => 'Settings (Main Menu)']);
        // Permission::create(['name' => 'Settings -> Site Access']);
        // Permission::create(['name' => 'Settings -> Site Update']);
        // Permission::create(['name' => 'Settings -> Configure Blog']);
        // Permission::create(['name' => 'Settings -> Configure Blog Update']);
        // Permission::create(['name' => 'Settings -> Backup E-Mail']);
        // Permission::create(['name' => 'Settings -> Backup Logs & Links']);
        // Permission::create(['name' => 'Settings -> Validations']);
        // Permission::create(['name' => 'Dashboard']);
        // Permission::create(['name' => 'Image Creation -> Gallery ( DB ) -> Delete']);
        // Permission::create(['name' => 'User Details -> All Users List']);
        // Permission::create(['name' => 'Inventory -> Counts Report']);
        // Permission::create(['name' => 'Inventory -> Counts Report -> Delete']);
        // Permission::create(['name' => 'Pending Listing ( DB ) -> Edit']);
        // Permission::create(['name' => 'Pending Listing ( DB ) -> Delete']);
        // Permission::create(['name' => 'Listing -> Search Listing -> Delete']);
        // Permission::create(['name' => 'Listing -> Search Listing -> Edit']);
        // Permission::create(['name' => 'Listing -> Search Listing']);
        // Permission::create(['name' => 'Pending Listing ( DB ) -> Reject ( DB )']);
        // Permission::create(['name' => 'Pending Listing ( DB ) -> Update ( DB )']);
        // Permission::create(['name' => 'Pending Listing ( DB ) -> Save as Draft']);
        // Permission::create(['name' => 'Pending Listing ( DB ) -> Publish to Website']);
        // Permission::create(['name' => 'RA-Updated Listings (MS)']);
        // Permission::create(['name' => 'Inventory -> Manage Inventory -> Edit ( DB )']);
        // Permission::create(['name' => 'Inventory -> Blogger Articles']);
        // Permission::create(['name' => 'Product Listing > AI Chat Bots']);
        // Permission::create(['name' => 'Product Listing > Bulk Listing Upload']);
        // Permission::create(['name' => 'Product Listing > Bulk Listing Review (Edit)']);
        // Permission::create(['name' => 'Product Listing > Bulk Listing Review (Delete)']);
        // Permission::create(['name' => 'Product Listing > Bulk Listing Review (Save to DB)']);
        // Permission::create(['name' => 'Product Listing > Bulk Listing Review (Publish To Website)']);
        // Permission::create(['name' => 'Inventory > Review Inventory (M/S) > Export']);
        // Permission::create(['name' => 'Product Listing > Search Listing (M/S) > Discount']);
        // Permission::create(['name' => 'Create Duplicate Listing Button']);
        // Permission::create(['name' => 'Update Listing ( M/S ) -> Bulk Delete']);
        // Permission::create(['name' => 'Pending Listing ( DB ) -> Bulk Delete']);
        // Permission::create(['name' => 'Analytics Dashboard']);


        User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'status'   => 1,
            'mobile'   => '123456789',
        ])->assignRole($adminRole)->assignRole($writerRole);

        $adminRole->givePermissionTo(Permission::all());

        User::create([
            'name'     => 'Writer',
            'email'    => 'writer@example.com',
            'password' => bcrypt('admin123'),
            'status'   => 1,
            'mobile'   => '123456789',
        ])->assignRole($writerRole);

        User::find(1)->assignRole($adminRole)->assignRole($writerRole);

        $adminRole->givePermissionTo(Permission::all());
    }
}
