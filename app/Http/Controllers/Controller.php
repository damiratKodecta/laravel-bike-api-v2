<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *      title="Bike API",
 *      version="1.0.1",
 *      description="API for the Bike preparation",
 *      @OA\Contact(
 *          email="damir.omerasevic@kodecta.com"
 *      ),
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
