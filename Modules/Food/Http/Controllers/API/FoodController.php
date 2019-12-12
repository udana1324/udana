<?php


namespace Modules\Food\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Food\Http\Controllers\API\BaseController as BaseController;
use Modules\Food\Entities\FoodData;

class FoodController extends Controller
{
    public function index()
    {
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
         
         $data = FoodData::all();

        return $this->sendResponse($data->toArray(), 'Data retrieved successfully.');
    }
}

?>