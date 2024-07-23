<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponses;
    public function include(string $relationship ,Request $request) :bool
    {
        //Auth::login;
        //auth()->login();
        $param = $request->get('include');
        //$param = request()->get('include');
        if(!isset($param)){
            return false;
        }

        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }
}