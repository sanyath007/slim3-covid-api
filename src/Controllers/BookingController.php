<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function generateOrderNo($request, $response, $args)
    {
        $order = Order::orderBy('order_no', 'DESC')->first();

        $startId = substr((date('Y') + 543), 2);
        $tmpLastId =  ((int)(substr($order->order_no, 4))) + 1;
        $lastId = $startId.sprintf("%'.05d", $tmpLastId);

        return $response
                ->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($lastId, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }

    public function getAll($request, $response, $args)
    {
        $page = (int)$request->getQueryParam('page');
        $link = 'http://localhost'. $request->getServerParam('REDIRECT_URL');
        $orders = paginate(Order::with('orderItem', 'dept'), 10, $page, $link);
        
        $data = json_encode($orders, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE);

        return $response
                ->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write($data);
    }
    
    public function getById($request, $response, $args)
    {
        $order = Order::where('id', $args['id'])->first();

        return $response
                ->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($order, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }

    public function store($request, $response, $args)
    {
        $post = (array)$request->getParsedBody();

        $order = new Order;
        $order->order_no = $post['order_no'];
        $order->order_date = $post['order_date'];
        $order->order_by = $post['order_by'];
        $order->order_dept = $post['order_dept'];
        $order->order_reason = $post['order_reason'];
        $order->remark = $post['remark'];
        // $order->status = $post['status'];

        if($order->save()) {
            try {
                foreach($post['items'] as $item) {
                    $orderItem = new OrderItem;
                    $orderItem->no = $item['no'];
                    $orderItem->order_id = $order->id;
                    $orderItem->item_id = $item['item_id'];
                    $orderItem->amount = $item['amount'];
                    $orderItem->total = $item['total'];
                    $orderItem->save();
                }
                
                return $response
                        ->withStatus(200)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode($order, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            } catch (\Exception $ex) {
                /** Delete last record of orders data if insert failed */
                Order::find($order->id)->delete();

                return $response
                        ->withStatus(500)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode([
                            'status' => 0,
                            'message' => $ex->getMessage()
                        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            }
        }
    }
}
