<?php

namespace App\Shop\Employees\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Employees\Employee;
use App\Shop\Stores\Store;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface extends BaseRepositoryInterface
{
    public function listEmployees(string $order = 'id', string $sort = 'desc'): Collection;

    public function createEmployee(array $params) : Employee;

    public function findEmployeeById(int $id) : Employee;

    public function updateEmployee(array $params) : bool;

    public function syncRoles(array $roleIds);

    public function listRoles() : Collection;

    public function hasRole(string $roleName) : bool;

    public function isAuthUser(Employee $employee): bool;

    public function associateStore(Store $store);

    public function findEmployeeStores() : Collection;

    public function syncStores(array $params);

    public function employeesWithoutStore(): Collection;


}
