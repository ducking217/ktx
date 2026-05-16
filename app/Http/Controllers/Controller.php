<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**

 * Khu vực: Class
 
 * Vai trò: Mô tả chức năng chính của lớp trong module tương ứng.

 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
