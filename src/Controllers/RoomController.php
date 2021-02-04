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
            $data = paginate(Room::with('roomType', 'roomGroup')->orderBy('room_group'), 10, $page, $link);
        } else {
            $data = [
                'items' => Room::with('roomType', 'roomGroup')->orderBy('room_group')->get()
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

        $room = new Room;
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
