<?php

namespace Tests\Unit\Stores;

use App\Shop\Stores\Store;
use App\Shop\Products\Product;
use App\Shop\Stores\Repositories\StoreRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreUnitTest extends TestCase
{


  /** @test */
  public function it_can_save_the_cover_image_properly_in_file_storage()
  {
      $cover = UploadedFile::fake()->image('cover.jpg', 600, 600);

      $store = factory(Store::class)->create();
      $storeRepo = new StoreRepository($store);
      $filename = $storeRepo->saveCoverImage($cover);

      $exists = Storage::disk('public')->exists($filename);

      $this->assertTrue($exists);
  }

  /** @test */
  public function it_can_detach_all_the_products()
  {
      $store = factory(Store::class)->create();
      $products = factory(Product::class, 4)->create();

      $storeRepo = new StoreRepository($store);

      $ids = $products->transform(function (Product $product) {
          return $product->id;
      })->all();

      $storeRepo->syncProducts($ids);

      $this->assertCount(4, $storeRepo->getProducts());

      $storeRepo->detachProducts();

      $this->assertCount(0, $storeRepo->getProducts());
  }


}
