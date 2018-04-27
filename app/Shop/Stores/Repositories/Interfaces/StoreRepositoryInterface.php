<?php

namespace App\Shop\Stores\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Stores\Store;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;

interface StoreRepositoryInterface extends BaseRepositoryInterface
{
  public function listStores(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

  public function createStore(array $data) : Store;

  public function updateStore(array $params, int $id) : bool;

  public function findStoreById(int $id) : Store;

  public function deleteStore(Store $store) : bool;

  public function getProducts() : Collection;

  public function saveCoverImage(UploadedFile $file) : string;

  public function searchStore(string $text) : Collection;

}
