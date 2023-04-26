<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Password_historie;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol1 = Role::create(['name' => 'Administrador']);
        $rol2 = Role::create(['name' => 'Trabajador']);
        $rol3 = Role::create(['name' => 'Cliente']);
        
        $user1 = User::create(['name' => 'Reynier','last_name' => 'Sayú Belón','email' => 'rsayu@nauta.cu','id_number' => '85041927545','password' => '$2y$10$35rJDVz5jLEgHuFryclQOOnbyIs5YKth/WDAlXXHfsVnZdwjUJ1uS'])->assignRole($rol1);
        $user2 = User::create(['name' => 'Andres','last_name' => 'Sayú Belón','email' => 'asayu@nauta.cu','id_number' => '88071400625','password' => '$2y$10$35rJDVz5jLEgHuFryclQOOnbyIs5YKth/WDAlXXHfsVnZdwjUJ1uS'])->assignRole($rol2);
        $user3 = User::create(['name' => 'Imara','last_name' => 'García Hernández','email' => 'imagimg@nauta.cu','id_number' => '85010907033','password' => '$2y$10$35rJDVz5jLEgHuFryclQOOnbyIs5YKth/WDAlXXHfsVnZdwjUJ1uS'])->assignRole($rol2);
        $user4 = User::create(['name' => 'Coralia','last_name' => 'Hernandez Herrera','email' => 'cocahh53@gmail.com','id_number' => '53092100615','password' => '$2y$10$35rJDVz5jLEgHuFryclQOOnbyIs5YKth/WDAlXXHfsVnZdwjUJ1uS'])->assignRole($rol2);
        
        Permission::create(['name' => 'rol.admin','nombre_real' => 'Permiso de Administración'])->syncRoles($rol1);
        Permission::create(['name' => 'rol.trab','nombre_real' => 'Permiso de Trabajadores'])->syncRoles($rol2);
        Permission::create(['name' => 'rol.cli','nombre_real' => 'Permiso de Clientes'])->syncRoles([$rol3]);
        
        Password_historie::create(['user_id' => $user1->id,'password' => '$2y$10$35rJDVz5jLEgHuFryclQOOnbyIs5YKth/WDAlXXHfsVnZdwjUJ1uS']);
        Password_historie::create(['user_id' => $user2->id,'password' => '$2y$10$35rJDVz5jLEgHuFryclQOOnbyIs5YKth/WDAlXXHfsVnZdwjUJ1uS']);
        Password_historie::create(['user_id' => $user3->id,'password' => '$2y$10$35rJDVz5jLEgHuFryclQOOnbyIs5YKth/WDAlXXHfsVnZdwjUJ1uS']);
        Password_historie::create(['user_id' => $user4->id,'password' => '$2y$10$35rJDVz5jLEgHuFryclQOOnbyIs5YKth/WDAlXXHfsVnZdwjUJ1uS']);
    }
}
