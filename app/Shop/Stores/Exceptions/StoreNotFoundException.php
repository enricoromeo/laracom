<?php

namespace App\Shop\Stores\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoreNotFoundException extends NotFoundHttpException
{

    /**
     * StoreNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Store not found.');
    }
}
