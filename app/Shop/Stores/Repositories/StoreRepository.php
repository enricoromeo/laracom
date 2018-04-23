<?php

namespace App\Shop\Stores\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\Stores\Exceptions\StoreInvalidArgumentException;
use App\Shop\Stores\Exceptions\StoreNotFoundException;
use App\Shop\Stores\Store;
use App\Shop\Stores\Repositories\Interfaces\StoreRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StoreRepository extends BaseRepository implements StoreRepositoryInterface
{
    public function __construct(Store $store)
    {
        parent::__construct($store);
        $this->model = $store;
    }

    /**
     * List all the stores
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listStores(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }
    /**
     * Create the store
     *
     * @param array $params
     * @return Store
     */
    public function createStore(array $params) : Store
    {
        try {
            $store = new Store($params);
            $store->save();
            return $store;
        } catch (QueryException $e) {
            throw new StoreInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the store
     *
     * @param array $params
     * @param int $id
     * @return bool
     */
    public function updateStore(array $params, int $id) : bool
    {
        try {
            return $this->update($params, $id);
        } catch (QueryException $e) {
            throw new StoreInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Find the store by ID
     *
     * @param int $id
     * @return Store
     */
    public function findStoreById(int $id) : Store
    {
        try {
            return $this->transformStore($this->findOneOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new StoreNotFoundException($e->getMessage());
        }
    }

    /**
     * Delete the store
     *
     * @param Store $store
     * @return bool
     */
    public function deleteStore(Store $store) : bool
    {
        $store->products()->delete();
        return $store->delete();
    }


    /**
     * @param UploadedFile $file
     * @return string
     */
    public function saveCoverImage(UploadedFile $file) : string
    {
        return $file->store('stores', ['disk' => 'public']);
    }

    /**
     * Detach the categories
     */
    public function detachProducts()
    {
        $this->model->products()->detach();
    }


    /**
     * Return the categories which the product is associated with
     *
     * @return Collection
     */
    public function getProducts() : Collection
    {
        return $this->model->products()->get();
    }

    /**
     * Sync the products
     *
     * @param array $params
     */
    public function syncProducts(array $params)
    {
        $this->model->products()->sync($params);
    }


}
