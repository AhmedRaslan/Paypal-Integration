<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function Index()
    {
        return view('admin.orders');
    }

    public function Show(Request $request)
    {
        // Read value
        $draw = $request->get('draw'); // Redraw the table
        $start = $request->get("start"); // Where to start (Skip all below)
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Order::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Order::select('count(*) as allcount')->where('order_id', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Order::orderBy($columnName, $columnSortOrder)
            ->where('orders.order_id', 'like', '%' . $searchValue . '%')
            ->select('orders.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $order_id = $record->order_id;
            $name = $record->name;
            $desc = $record->desc;
            $amount = $record->amount;
            $status = $record->status;
            $created_at = $record->created_at;
            $updated_at = $record->updated_at;

            $data_arr[] = array(
                "order_id" => $order_id,
                "name" => $name,
                "desc" => $desc,
                "amount" => $amount,
                "status" => $status,
                "created_at" => $created_at,
                "updated_at" => $updated_at,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        return response()->json($response);
    }
}
