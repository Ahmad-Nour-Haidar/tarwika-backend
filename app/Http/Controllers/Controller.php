<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponder;
use App\Traits\ApiResponseTrait;
use App\Traits\FileStorageTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    use  ApiResponder;
    use  FileStorageTrait;
}
