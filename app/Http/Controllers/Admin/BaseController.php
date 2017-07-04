<?php
namespace App\Http\Controllers\Admin;
use Laravel\Lumen\Routing\Controller as Controller;

class BaseController extends Controller
{
    function __construct(){
        $this->middleware('admin_auth');
    }
}