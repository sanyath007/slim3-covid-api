<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use Respect\Validation\Validator as v;
use App\Models\Room;

class RoomController extends Controller
{
    public function getAll($request, $response, $args)
    {
        $page = (int)$request->getQueryParam('page');

        if ($page) {
            $link = 'http://localhost'. $request->getServerParam('REDIRECT_URL');
            $data = paginate(Room::with('roomType', 'roomGroup', 'building')->orderBy('room_group'), 10, $page, $link);
        } else {
            $data = [
                'items' => Room::with('roomType', 'roomGroup', 'building')->orderBy('room_group')->get()
            ];
        }

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }
    
    public function getById($request, $response, $args)
    {
        $room = Room::where('id', $args['id'])->first();
                    
        $data = json_encode($room, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE);

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write($data);
    }

    public function store($request, $response, $args)
    {
        // TODO: modify validation
        // $validation = $this->validator->validate($request, [
        //     'name' => v::notEmpty(),
        //     'unit' => v::notEmpty()->numeric(),
        //     'cost' => v::notOptional()->floatVal(),
        //     'stock' => v::notOptional()->numeric(),
        //     'min' => v::notOptional()->numeric(),
        //     'balance' => v::notOptional()->numeric(),
        //     'item_type' => v::notEmpty()->numeric(),
        //     'item_group' => v::notEmpty()->numeric(),
        // ]);
        
        // if ($validation->failed()) {
        //     $data = [
        //         'status' => 0,
        //         'errors' => $validation->getMessages(),
        //         'message' => 'Validation Error!!'
        //     ];

        //     return $response->withStatus(200)
        //         ->withHeader("Content-Type", "application/json")
        //         ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        // }

        $post = (array)$request->getParsedBody();
        
        // TODO: separate uploads to another method
        /** Upload image */
        $link = 'http://'.$request->getServerParam('SERVER_NAME').$request->getServerParam('REDIRECT_URL');
        if(preg_match("/^data:image\/(?<extension>(?:png|gif|jpg|jpeg));base64,(?<image>.+)$/", $post['room_img_url'], $matchings))
        {
            $img_data = file_get_contents($post['room_img_url']);
            $extension = $matchings['extension'];
            $img_name = uniqid().'.'.$extension;
            $img_url = str_replace('/rooms', '/assets/uploads/'.$img_name, $link);
            $file_to_upload = 'assets/uploads/'.$img_name;

            if(file_put_contents($file_to_upload, $img_data)) {
                // echo $img_url;
            }
        }

        $room = new Room;
        $room->room_no = $post['room_no'];
        $room->room_name = $post['room_name'];
        $room->description = $post['description'];
        $room->room_type = $post['room_type'];
        $room->room_group = $post['room_group'];
        $room->building_id = $post['building_id'];
        $room->floor = $post['floor'];
        $room->room_img_url = $img_url;
        $room->room_status = 0;
        
        if($room->save()) {
            $data = [
                'status' => 1,
                'message' => 'Insertion successfully!!',
                'item' => $room
            ];

            return $response->withStatus(200)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }
    }

    public function update($request, $response, $args)
    {
        $validation = $this->validator->validate($request, [
            'name' => v::notEmpty(),
            'unit' => v::notEmpty()->numeric(),
            'cost' => v::notOptional()->floatVal(),
            'stock' => v::notOptional()->numeric(),
            'min' => v::notOptional()->numeric(),
            'balance' => v::notOptional()->numeric(),
            'item_type' => v::notEmpty()->numeric(),
            'item_group' => v::notEmpty()->numeric(),
        ]);
        
        if ($validation->failed()) {
            $data = [
                'status' => 0,
                'errors' => $validation->getMessages(),
                'message' => 'Validation Error!!'
            ];

            return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }

        $post = (array)$request->getParsedBody();

        $room = Room::where('id', $args['id'])->first();
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
        $room = Room::where('id', $args['id'])->first();
        
        if($room->delete()) {
            return $response->withStatus(200)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($room, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }
    }
}
