<?php

namespace Modules\Food\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
         
         $data = FoodData::all()->where('flag_active', 'Y');

        return view('food::index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'category'=> 'required',
            'price'=> 'required'
        ]);

        $name = strtolower($request->input('name'));
        $category = $request->input('category');
        $price = $request->input('price');
        $status = $request->input('status');
        $user = Auth::user()->user_name;

        $countKode = DB::table('food_data')->select(DB::raw("MAX(RIGHT(code,3)) AS num"))->where('category', $category)->first();
        $count = $countKode->num;
        $counter = $count + 1;

        if ($counter < 10) {
            $code = $category.'00'.$counter;
        }
        elseif ($counter < 100) {
            $code = $category.'0'.$counter;
        }

          $food = FoodData::firstOrCreate(
            ['code' => $code,'name' => $name],
            [
              'category' => $category,
              'price' => $price,
              'flag_ready' => $status,
              'user' => $user,
              'flag_active' => 'Y'
            ]
          );

          $food->save();
          
          if ($food->wasRecentlyCreated) {
            return redirect('/food')->with('success', 'Data '.strtoupper($name).' Saved!');
          }
          else {
            return redirect('/food')->with('error', 'Item '.strtoupper($name).' Already Exist!');
          }
    }

    public function update(Request $request)
    {
      $id = $request->input('id_item');
      $name = strtolower($request->input('name_edit'));
      $category = $request->input('category_edit');
      $price = $request->input('price_edit');
      $status = $request->input('status_edit');
      $user = Auth::user()->user_name;

      $update = DB::table('food_data')
                            ->where('id', $id)
                            ->update(['name' => $name, 'category' => $category, 'price' => $price, 'flag_ready' => $status, 'user' => $user]);

      return redirect('/food')->with('success', 'Data '.strtoupper($name).' Updated!');
      
    }

    public function delete(Request $request)
    {
      $id = $request->input('id_item');
      $name = strtolower($request->input('name'));
      $user = Auth::user()->user_name;

      $update = DB::table('food_data')
                            ->where('id', $id)
                            ->update(['flag_active' => 'N', 'user' => $user]);
      $request->session()->flash('del', 'Data '.strtoupper($name).' Deleted!');
      return response()->json(['success'=>'Data '.strtoupper($name).' Deleted!']);
    }
}
