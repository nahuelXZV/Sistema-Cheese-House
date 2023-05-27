<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $admin = Role::create(['name' => 'Administrador']);
        $vendedor = Role::create(['name' => 'Vendedor']);
        $cocinero = Role::create(['name' => 'Cocinero']);
        $almacen = Role::create(['name' => 'Almacen']);

        //Permisos
        Permission::create(['name' => 'usuarios', 'description' => 'Gestionar usuarios'])->syncRoles($admin);
        Permission::create(['name' => 'roles', 'description' => 'Gestionar roles'])->syncRoles($admin);
        Permission::create(['name' => 'ingredientes', 'description' => 'Gestionar Ingredientes'])->syncRoles($admin);
        Permission::create(['name' => 'productos', 'description' => 'Gestionar Productos'])->syncRoles($admin);
        Permission::create(['name' => 'recetas', 'description' => 'Gestionar Recetas'])->syncRoles($admin);
        Permission::create(['name' => 'productos', 'description' => 'Gestionar Productos'])->syncRoles($admin);
        Permission::create(['name' => 'proveedores', 'description' => 'Gestionar Proveedores'])->syncRoles($admin);
        Permission::create(['name' => 'compras', 'description' => 'Gestionar Compras'])->syncRoles($admin);
        Permission::create(['name' => 'pedidos', 'description' => 'Gestionar Pedidos'])->syncRoles($admin);

        User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('Administrador');

        // crear 50 ingredientes con datos random de forma manual sin un factory
        for ($i = 0; $i < 50; $i++) {
            $ingrediente = new \App\Models\Ingrediente();
            $ingrediente->nombre = 'Ingrediente ' . $i;
            $ingrediente->unidad = 'Unidad ' . $i;
            $ingrediente->stock = rand(1, 100);
            $ingrediente->precio_unidad = rand(1, 100);
            $ingrediente->stock_minimo = rand(1, 100);
            $ingrediente->stock_maximo = rand(1, 100);
            $ingrediente->descripcion = 'Descripcion ' . $i;
            $ingrediente->save();
        }
    }
}
