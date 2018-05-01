<?php

use App\Shop\Employees\Employee;
use App\Shop\Roles\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Employee::class)->create();
        $employee = Employee::find(3);
        factory(Role::class)->create(['name' => 'Store Manager'])->each(function(Role $role) use ($employee) {
            $employee->roles()->save($role);
        });

    }
}
