<?php

namespace App\Shop\Stores\Transformations;

use App\Shop\Stores\Store;
use Illuminate\Support\Facades\Storage;

trait StoreTransformable
{
    /**
     * Transform the store
     *
     * @param Store $store
     * @return Store
     */
    protected function transformStore(Store $store)
    {
        $file = Storage::disk('public')->exists($store->cover) ? $store->cover : null;

        $store = new Store;
        $store->id = (int) $store->id;
        $store->name = $store->name;
        $store->slug = $store->slug;
        $store->description = $store->description;
        $store->cover = $file;
        $store->status = $store->status;

        return $store;
    }
}
