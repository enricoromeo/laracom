<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Stores\Store;
use App\Shop\Stores\Repositories\Interfaces\StoreRepositoryInterface;
use App\Shop\Stores\Repositories\StoreRepository;
use Illuminate\Support\Facades\Auth;
use App\Shop\Stores\Transformations\StoreTransformable;





class DashboardController extends Controller
{

    use StoreTransformable;

  /**
   * @var EmployeeRepositoryInterface
   */
  private $employeeRepo;

  /**
   * @var StoreRepositoryInterface
   */
  private $storeRepo;

      /**
       * Dashboard Controller constructor.
       * @param EmployeeRepositoryInterface $employeeRepository
       */
      public function __construct(

          EmployeeRepositoryInterface $employeeRepository,
          StoreRepositoryInterface $storeRepository

      ) {

          $this->employeeRepo = $employeeRepository;
          $this->storeRepo = $storeRepository;

      }

    public function index()
    {
        $currentAuthUserId =Auth::guard('admin')->user()->id;

        $employee = $this->employeeRepo->findEmployeeById($currentAuthUserId);

        $employeeRepo = new EmployeeRepository($employee);
        $list = $employeeRepo->findEmployeeStores();

        $employeeStores = $list->map(function (Store $item) {
            return $this->transformStore($item);
        })->all();

        return view('admin.dashboard', [
            'employeeStores' => $this->storeRepo->paginateArrayResults($employeeStores, 8)
        ]);


    }


}
