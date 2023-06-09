<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Producto;
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
        Permission::create(['name' => 'usuarios', 'description' => 'Gestionar Usuarios'])->syncRoles($admin);
        Permission::create(['name' => 'roles', 'description' => 'Gestionar Roles'])->syncRoles($admin);
        Permission::create(['name' => 'ingredientes', 'description' => 'Gestionar Ingredientes'])->syncRoles($admin);
        Permission::create(['name' => 'productos', 'description' => 'Gestionar Productos'])->syncRoles($admin);
        Permission::create(['name' => 'recetas', 'description' => 'Gestionar Recetas'])->syncRoles($admin);
        Permission::create(['name' => 'proveedores', 'description' => 'Gestionar Proveedores'])->syncRoles($admin);
        Permission::create(['name' => 'compras', 'description' => 'Gestionar Compras'])->syncRoles($admin);
        Permission::create(['name' => 'pedidos', 'description' => 'Gestionar Pedidos'])->syncRoles($admin);
        Permission::create(['name' => 'cocina', 'description' => 'Gestionar Estado En La Cocina'])->syncRoles($admin);
        Permission::create(['name' => 'eliminar', 'description' => 'Puede Eliminar Los Datos'])->syncRoles($admin);
        Permission::create(['name' => 'reportes', 'description' => 'Descargar Reportes'])->syncRoles($admin);
        Permission::create(['name' => 'pantalla', 'description' => 'Mostrar La Pantalla Del Cliente'])->syncRoles($admin);

        User::create([
            'name' => 'Nahuel Zalazar',
            'email' => 'zvnahuel63@gmail.com',
            'password' => bcrypt('N4hu3lZ4l4z4r2023'),
        ])->assignRole('Administrador');

        Producto::create([
            'nombre' => 'Pizza Mitad-Mitad',
            'precio' => 0.00,
            'descripcion' => '',
            'tamaño' => 'Familiar',
            'url_imagen' => 'https://www.dominospizza.es/imagenes/pizzas/pepperoni.jpg',
            'is_active' => true,
            'categoria' => 'Pizza',
        ]);
    }
}
