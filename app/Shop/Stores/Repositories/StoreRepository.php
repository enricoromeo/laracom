<?php

namespace App\Shop\Stores\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\Stores\Exceptions\StoreInvalidArgumentException;
use App\Shop\Stores\Exceptions\StoreNotFoundException;
use App\Shop\Stores\Store;
use App\Shop\Stores\Repositories\Interfaces\StoreRepositoryInterface;
use App\Shop\Stores\Transformations\StoreTransformable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StoreRepository extends BaseRepository implements StoreRepositoryInterface
{
    use StoreTransformable;

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
     * Return the categories which the product is associated with
     *
     * @return Collection
     */
    public function getProducts() : Collection
    {
        return $this->model->products()->get();
    }

    /**
     * @param $file
     * @param null $disk
     * @return bool
     */
    public function deleteFile(array $file, $disk = null) : bool
    {
        return $this->update(['cover' => null], $file['store']);
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchStore(string $text) : Collection
    {
        return $this->model->searchStore($text);
    }

    /**
     * Detach the employees
     */
    public function detachEmployees()
    {
        $this->model->employees()->detach();
    }

    /**
     * Return the employees which the Store is associated with
     *
     * @return Collection
     */
    public function getEmployees() : Collection
    {
        return $this->model->employees()->get();
    }

    /**
     * Sync the employees
     *
     * @param array $params
     */
    public function syncEmployees(array $params)
    {
        $this->model->employees()->sync($params);
    }


}
