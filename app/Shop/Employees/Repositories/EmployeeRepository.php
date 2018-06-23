<?php

namespace App\Shop\Employees\Repositories;

use App\Shop\Base\BaseRepository;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Exceptions\EmployeeNotFoundException;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Shop\Stores\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    /**
     * EmployeeRepository constructor.
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        parent::__construct($employee);
        $this->model = $employee;
    }

    /**
     * List all the employees
     *
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function listEmployees(string $order = 'id', string $sort = 'desc'): Collection
    {
        return $this->all(['*'], $order, $sort);
    }

    /**
     * Create the employee
     *
     * @param array $params
     * @return Employee
     */
    public function createEmployee(array $params): Employee
    {
        $collection = collect($params);

        $employee = new Employee(($collection->except('password'))->all());
        $employee->password = bcrypt($collection->only('password'));
        $employee->save();

        return $employee;
    }

    /**
     * Find the employee by id
     *
     * @param int $id
     * @return Employee
     */
    public function findEmployeeById(int $id): Employee
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new EmployeeNotFoundException;
        }
    }

    /**
     * Update employee
     *
     * @param array $params
     * @return bool
     */
    public function updateEmployee(array $params): bool
    {
        return $this->model->update($params);
    }

    /**
     * @param array $roleIds
     */
    public function syncRoles(array $roleIds)
    {
        $this->model->roles()->sync($roleIds);
    }

    /**
     * @return Collection
     */
    public function listRoles(): Collection
    {
        return $this->model->roles()->get();
    }

    public function listRolesByEmployee(Employee $employee): Collection
    {
       return $employee->roles()->get();
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->model->hasRole($roleName);
    }

    /**
     * @param Employee $employee
     * @return bool
     */
    public function isAuthUser(Employee $employee): bool
    {
        $isAuthUser = false;
        if (Auth::guard('admin')->user()->id == $employee->id)
        {
           $isAuthUser = true;
        }
        return $isAuthUser;
    }


    /**
     * Associate a store to a Employee
     *
     * @param Store $store
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function associateStore(Store $store)
    {
        return $this->model->stores()->save($store);
    }

    /**
     * Return all the stores associated with the employee
     *
     * @return mixed
     */
    public function findStores() : Collection
    {
        return $this->model->stores;
    }

    /**
     * @param array $params
     */
    public function syncStores(array $params)
    {
        return $this->model->stores()->sync($params);
    }



    /**
     * List all the employees without Store
      * @return array
     */
    public function employeesWithoutStore(): Collection
    {
       return $this->model->doesntHave('stores')->paginate(15)->get();
    }



}
