<?php

namespace App\Shop\Stores;

use App\Shop\Products\Product;
use App\Shop\Employees\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
        return $this->hasMany(Product::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    /**
     * @param string $term
     * @return Collection
     */
    public function searchStore(string $term) : Collection
    {
        return self::search($term)->get();
    }

}
