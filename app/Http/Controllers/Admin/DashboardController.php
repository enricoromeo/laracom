<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Shop\Employees\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{

  /**
   * @var EmployeeRepositoryInterface
   */
  private $employeeRepo;


      /**
       * Dashboard Controller constructor.
       * @param EmployeeRepositoryInterface $employeeRepository
       */
      public function __construct(

          EmployeeRepositoryInterface $employeeRepository

      ) {

          $this->employeeRepo = $employeeRepository;

      }

    public function index()
    {
        $currentAuthUserId =Auth::guard('admin')->user()->id;

        $employee = $this->employeeRepo->findEmployeeById($currentAuthUserId);

        $employeeRepo = new EmployeeRepository($employee);
        $employeeStores = $employeeRepo->findStores();

        return view('admin.dashboard', ['employeeStores' => $employeeStores]);
    }


}
