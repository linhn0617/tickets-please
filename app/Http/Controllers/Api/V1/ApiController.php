<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ApiController extends Controller
{
    use ApiResponses, AuthorizesRequests;

    protected $policyClass;

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

    public function isAble($ability, $targetModel)
    {
        return $this->authorize($ability, [$targetModel, $this->policyClass]);
        //授權成功會正常執行，回傳true
        //授權失敗會拋出AuthorizationException，而不是回傳false
    }
}