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
        ProductRepositoryInterface $productRepository
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


      $stores = $list->map(function (Store $item) {
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
        return view('admin.stores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStoreRequest $request)
    {
        $data = $request->except('_token', '_method');
        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover') && $request->file('cover') instanceof UploadedFile) {
            $data['cover'] = $this->storeRepo->saveCoverImage($request->file('cover'));
        }

        $store = $this->storeRepo->createStore($data);

        $request->session()->flash('message', 'Create successful');
        return redirect()->route('admin.stores.edit', $store->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
      return view('admin.stores.show', ['store' => $this->storeRepo->findStoreById($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $store = $this->storeRepo->findStoreById($id);

        return view('admin.stores.edit', [
            'store' => $store
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateStoreRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStoreRequest $request, int $id)
    {
        $store = $this->storeRepo->findStoreById($id);

        $data = $request->except('_token', '_method');
        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover') && $request->file('cover') instanceof UploadedFile) {
            $data['cover'] = $this->storeRepo->saveCoverImage($request->file('cover'));
        }

        $this->storeRepo->updateStore($data, $id);

        $request->session()->flash('message', 'Update successful');

        return redirect()->route('admin.stores.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $store = $this->storeRepo->findStoreById($id);

        $this->storeRepo->delete($id);

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.stores.index');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $this->storeRepo->deleteFile($request->only('store', 'image'), 'uploads');
        request()->session()->flash('message', 'Image delete successful');
        return redirect()->back();
    }
}
