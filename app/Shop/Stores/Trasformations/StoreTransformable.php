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

        $st = new Store;

        $st->id = (int) $store->id;
        $st->name = $store->name;
        $st->slug = $store->slug;
        $st->description = $store->description;
        $st->cover = $file;
        $st->status = $store->status;
        
        return $st;
    }
}
