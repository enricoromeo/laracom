<?php

namespace App\Http\Controllers\Admin\Stores;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop\Stores\Store;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Stores\Transformations\StoreTransformable;
use App\Shop\Tools\UploadableTrait;
use App\Shop\Stores\Repositories\Interfaces\StoreRepositoryInterface;
use App\Shop\Stores\Repositories\StoreRepository;
use App\Shop\Stores\Requests\CreateStoreRequest;
use App\Shop\Stores\Requests\UpdateStoreRequest;

class StoreController extends Controller
{

    use StoreTransformable, UploadableTrait;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepo;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * ProductController constructor.
     * @param StoreRepositoryInterface $storeRepository
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        StoreRepositoryInterface $storeRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->storeRepo = $storeRepository;
        $this->productRepo = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $list = $this->storeRepo->listStores('id');

      if (request()->has('q') && request()->input('q') != '') {
          $list = $this->storeRepo->searchStore(request()->input('q'));
      }

      $store = $list->map(function (Store $item) {
          return $this->transformStore($item);
      })->all();

      return view('admin.stores.list', [
          'stores' => $this->storeRepo->paginateArrayResults($stores, 10)
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
