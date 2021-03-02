<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Booking;
use App\Models\BookingRoom;

class BookingController extends Controller
{
    public function generateOrderNo($request, $response, $args)
    {
        $bookings = Booking::orderBy('book_id', 'DESC')->first();

        $startId = substr((date('Y') + 543), 2);
        $tmpLastId =  ((int)(substr($bookings->book_id, 4))) + 1;
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

        $model = Booking::where('book_status', '=', 0)
                    ->with('an','an.patient','an.ward','room','user');

        $bookings = paginate($model, 'book_id', 10, $page, $link);
        
        $data = json_encode($bookings, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE);

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
        try {
            $post = (array)$request->getParsedBody();

            $booking = new Booking;
            $booking->an = $post['an'];
            $booking->book_date = $post['book_date'];
            $booking->description = $post['description'];
            $booking->remark = $post['remark'];
            $booking->room_types = $post['room_types'];
            $booking->user = $post['user'];
            $booking->ward = $post['ward'];

            if($booking->save()) {
                return $response
                        ->withStatus(200)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode([
                            'status' => 1,
                            'message' => 'Insertion successfully',
                            'booking' => $booking
                        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            } else {
                return $response
                    ->withStatus(500)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode([
                        'status' => 0,
                        'message' => 'Something went wrong!!'
                    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            }
        } catch (\Exception $ex) {
            return $response
                    ->withStatus(500)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode([
                        'status' => 0,
                        'message' => $ex->getMessage()
                    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }
    }

    public function checkin($request, $response, $args)
    {
        try {
            $post = (array)$request->getParsedBody();
            
            $br = new BookingRoom();
            $br->book_id = $post['bookId'];
            $br->room_id = $post['roomId'];
            $br->checkin_date = $post['checkinDate'];
            $br->checkin_time = $post['checkinTime'];
            $br->have_observer = $post['haveObserver'];
            $br->observer_name = $post['observerName'];
            $br->observer_name = $post['observerTel'];

            if ($br->save()) {
                Booking::find($post['bookId'])->update(['book_status' => 1]);

                return $response
                    ->withStatus(200)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode([
                        'status' => 1,
                        'message' => 'Insertion successfully',
                        'data' => $br,
                    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            } else {
                return $response
                    ->withStatus(500)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode([
                        'status' => 0,
                        'message' => 'Something went wrong!!'
                    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            }
        } catch (\Exception $ex) {
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
