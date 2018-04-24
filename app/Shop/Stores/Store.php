<?php

namespace App\Shop\Stores;

use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Store extends Model
{
    use Eloquence;

    protected $searchableColumns = ['name', 'description'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'name',
        'slug',
        'description',
        'cover',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    public function products()
    {
        return $this->HasMany(Product::class);
    }

}
