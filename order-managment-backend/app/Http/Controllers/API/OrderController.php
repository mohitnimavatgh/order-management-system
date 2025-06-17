<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Validator;

class OrderController extends Controller
{
    public function index(Request $request) {        
        try {
            $orders = Order::all();
            return response()->json(['message' => "Data get Successfully", 'data' => $orders]);
        } catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request) {        
        try {

            $validator = Validator::make($request->all(), [
                'customer_name' => 'required',
                'item_name' => 'required',
                'price' => 'required|numeric',
                'status' => 'required|in:pending,paid,cancelled',
            ]);

            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $order = Order::create($request->all());
            
            return response()->json(['message' => "Order created Successfully", 'data' => $order], 201);

        } catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {        
        try {

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:paid,cancelled',
            ]);

            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $order = Order::find($id);
            $order->update(['status' => $request->status]);
            
            return response()->json(['message' => "Order status update Successfully", 'data' => $order], 201);
            
        } catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
