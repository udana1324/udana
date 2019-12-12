<?php

namespace Modules\Order\Http\Controllers;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Food\Entities\FoodData;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderDetail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $items = FoodData::select('id', 'name')
                    ->where([
                        ['flag_active', '=', 'Y'],
                        ['flag_ready', '=', 'Y']
                    ])
                    ->pluck('name', 'id');

        $dataOrder = Order::select('id','order_num', 'table_num', 'status')
                    ->where([
                        ['flag_active', '=', 'Y']
                    ])
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->get();
        $role = Auth::user()->role;

        return view('order::index', compact('items', 'dataOrder', 'role'));
    }

    public function report()
    {

        $username = Auth::user()->user_name;

        $dataOrder = Order::select('id','order_num', 'table_num', 'status', 'total_price')
                    ->where([
                        ['flag_active', '=', 'Y'],
                        ['user', '=', $username]
                    ])
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->get();

        return view('order::report', compact( 'dataOrder'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function getDataItem(Request $request)
    {
        $id = $request->input('id_item');

        $dataItem = DB::table('food_data')
                        ->select('price')
                        ->where([
                                 ['id', '=' , $id]
                                ])
                        ->first();

        return response()->json($dataItem);
    }

    public function store(Request $request)
    {
        $request->validate([
                'table'=>'required'
            ]);

            $tableNo = $request->input('table');
            $currentDate = now();
            $day = date("d", strtotime($currentDate));
            $month = date("m", strtotime($currentDate));
            $year = date("Y", strtotime($currentDate));
            $total = $request->input('total');
            $user = Auth::user()->user_name;

            $countNum = DB::table('orders')
                    ->select(DB::raw("MAX(RIGHT(order_num,3)) AS num"))
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->first();

            $count = $countNum->num;
            $counter = $count + 1;

            if ($counter < 10) {
                $code = 'erp'.$day.$month.$year.'-'.'00'.$counter;
            }
            elseif ($counter < 100) {
                $code = 'erp'.$day.$month.$year.'-'.'0'.$counter;
            }

            $orders = Order::firstOrCreate(
                ['order_num' => $code],
                [
                    'table_num' => $tableNo,
                    'total_price' => $total,
                    'status' => 'open',
                    'flag_active' => 'Y',
                    'user' => $user
                ]
            );

            $arrayItems = $request->input('val');
            if ($arrayItems != "") {
                $listItems = [];
                foreach ($arrayItems as $detail) {
                    $dataItems=[
                        'order_num' => $code,
                        'item_id' => $detail["idItem"],
                        'quantity_order' => $detail["qtyItem"],
                        'user' => $user,
                        'created_at' => now(),
                        'updated_at' => now()
                        ];
                    array_push($listItems, $dataItems);
                }          
                OrderDetail::insert($listItems);
            }

            if ($orders->wasRecentlyCreated) {
                return redirect('order')->with('success', 'Order '.strtoupper($code).' Created!');
            }
            else {
                return redirect('order')->with('error', 'Order '.strtoupper($code).' Failed!');
            }
    }

    public function editHeader(Request $request) 
    {
        $id = $request->input('id_order');

        $header = Order::select('order_num', 'table_num')
                        ->where([
                                 ['id', '=', $id],
                                 ['flag_active', '=' , 'Y']
                                ])
                        ->get();

        return response()->json($header);
    }

    public function editDetail(Request $request) 
    {
        $order_num = strtolower($request->input('order_num'));

        $detail = DB::table('order_details')
                        ->join('food_data', 'food_data.id', 'order_details.item_id')
                        ->select(
                                'order_details.item_id',
                                'order_details.order_num',
                                'order_details.quantity_order',
                                'food_data.name',
                                'food_data.price')
                        ->where([
                                 ['order_details.order_num', '=', $order_num],
                                 ['flag_active', '=' , 'Y']
                                ])
                        ->get();

        return response()->json($detail);
    }

    public function update(Request $request)
    {
      $id = $request->input('idOrder');
      $tableNo = $request->input('table_edit');
      $total = $request->input('totalEdit');
      $order_num = strtolower($request->input('order_no_edit'));
      $user = Auth::user()->user_name;

      $update = DB::table('orders')
                            ->where('id', $id)
                            ->update(['table_num' => $tableNo, 'total_price' => $total, 'user' => $user]);
      $deleteDetail = DB::table('order_details')->where('order_num', '=', $order_num)->delete();

      $arrayItems = $request->input('valEdit');
            if ($arrayItems != "") {
                $listItems = [];
                foreach ($arrayItems as $detail) {
                    $dataItems=[
                        'order_num' => $order_num,
                        'item_id' => $detail["idItem"],
                        'quantity_order' => $detail["qtyItem"],
                        'user' => $user,
                        'created_at' => now(),
                        'updated_at' => now()
                        ];
                    array_push($listItems, $dataItems);
                }          
                OrderDetail::insert($listItems);
            }

      return redirect('/order')->with('success', 'Data '.strtoupper($order_num).' Updated!');
      
    }

    public function payment(Request $request)
    {
      $id = $request->input('idOrderPayment');
      $order_num = $request->input('order_no_payment');
      $user = Auth::user()->user_name;

      $update = DB::table('orders')
                            ->where('id', $id)
                            ->update(['status' => 'paid', 'user' => $user]);

      return redirect('/order')->with('success', 'Order '.strtoupper($order_num).' Paid!');
      
    }

    public function delete(Request $request)
    {
      $id = $request->input('id_order');
      $name = strtolower($request->input('num'));
      $user = Auth::user()->user_name;

      $update = DB::table('orders')
                            ->where('id', $id)
                            ->update(['flag_active' => 'N', 'user' => $user]);
      $request->session()->flash('del', 'Order '.strtoupper($name).' Deleted!');
      return response()->json(['success'=>'Order '.strtoupper($name).' Deleted!']);
    }
}
