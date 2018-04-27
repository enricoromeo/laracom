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



}
