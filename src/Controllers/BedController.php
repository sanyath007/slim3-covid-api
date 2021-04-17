<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use Respect\Validation\Validator as v;
use App\Models\Bed;

class BedController extends Controller
{
    public function getAll($request, $response, $args)
    {
        $page = (int)$request->getQueryParam('page');

        if ($page) {
            $link = 'http://localhost'. $request->getServerParam('REDIRECT_URL');
            $data = paginate(Bed::with('bedType', 'ward')->orderBy('bed_no'), 10, $page, $link);
        } else {
            $data = [
                'items' => Bed::with('bedType', 'ward')->orderBy('bed_no')->get()
            ];
        }

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }

    public function getById($request, $response, $args)
    {
        $room = Bed::where('bed_id', $args['id'])->first();
                    
        $data = json_encode($room, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE);

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write($data);
    }

    public function getByWard($request, $response, $args)
    {
        $rooms = Bed::where(['ward' => $args['ward'], 'bed_status' => 0])
                    ->orderBy('bed_no')
                    ->get();
                    
        $data = json_encode($rooms, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE);

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write($data);
    }
    
    public function getRoomsStatus($request, $response, $args)
    {
        $rooms = Bed::whereNotIn('bed_status', [2,3])
                    ->orderBy('bed_no')
                    ->get();
        $usedBeds = Bed::where(['bed_status' => 1])
                    ->with('bookingRoom', 'bookingRoom.booking')
                    ->with('bookingRoom.booking.an', 'bookingRoom.booking.an.patient')
                    ->orderBy('bed_no')
                    ->get();

        $data = json_encode([
            'beds' => $rooms, 
            'usedBeds' => $usedBeds
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE);

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write($data);
    }

    public function store($request, $response, $args)
    {
        $post = (array)$request->getParsedBody();

        try {
            // TODO: separate uploads to another method
            /** Upload image */
            // $link = 'http://'.$request->getServerParam('SERVER_NAME').$request->getServerParam('REDIRECT_URL');
            // if(preg_match("/^data:image\/(?<extension>(?:png|gif|jpg|jpeg));base64,(?<image>.+)$/", $post['bed_img_url'], $matchings))
            // {
            //     $img_data = file_get_contents($post['bed_img_url']);
            //     $extension = $matchings['extension'];
            //     $img_name = uniqid().'.'.$extension;
            //     $img_url = str_replace('/rooms', '/assets/uploads/'.$img_name, $link);
            //     $file_to_upload = 'assets/uploads/'.$img_name;

            //     if(file_put_contents($file_to_upload, $img_data)) {
            //         // echo $img_url;
            //     }
            // }

            $room = new Bed;
            $room->room_no = $post['room_no'];
            $room->room_name = $post['room_name'];
            $room->description = $post['description'];
            $room->room_type = $post['room_type'];
            $room->room_group = $post['room_group'];
            $room->building = $post['building'];
            $room->floor = $post['floor'];
            $room->room_img_url = $img_url;
            $room->room_status = 0;

            if($room->save()) {
                $newRoomId = $room->id;
                $amenities = explode(",", $post['amenities']);

                foreach($amenities as $amenity) {
                    $ra = new RoomAmenities();
                    $ra->room_id = $newRoomId;
                    $ra->amenity_id = $amenity;
                    $ra->status = 1;
                    $ra->save();
                }

                $data = [
                    'status' => 1,
                    'message' => 'Insertion successfully!!',
                    'item' => $room
                ];

                return $response->withStatus(200)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            } // end if
        } catch (\Throwable $th) {
            /** Delete new room if error occurs */
            Bed::find($newRoomId)->delete();
            
            /** And set data to client with http status 500 */
            $data = [
                'status' => 0,
                'message' => 'Something went wrong!!'
            ];

            return $response->withStatus(500)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        } // end trycatch
    }

    public function update($request, $response, $args)
    {
        $post = (array)$request->getParsedBody();

        $room = Bed::where('id', $args['id'])->first();
        $room->name = $post['name'];
        $room->unit = $post['unit'];
        $room->cost = $post['cost'];
        $room->stock = $post['stock'];
        $room->min = $post['min'];
        $room->balance = $post['balance'];
        $room->item_type = $post['item_type'];        
        $room->item_group = $post['item_group'];

        if($room->save()) {   
            $data = [
                'status' => 1,
                'message' => 'Update successfully!!',
                'item' => $room
            ];

            return $response->withStatus(200)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }
    }

    public function delete($request, $response, $args)
    {
        $room = Bed::where('id', $args['id'])->first();
        
        if($room->delete()) {
            return $response->withStatus(200)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($room, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }
    }
}
