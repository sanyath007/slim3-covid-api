<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Amenity;

class AmenityController extends Controller
{
    public function getAll($request, $response, $args)
    {
        $amenities = Amenity::all();

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($amenities, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }
    
    public function getById($request, $response, $args)
    {
        $amenity = Amenity::where('amenity_id', $args['id'])->first();

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($amenity, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }

    public function store($request, $response, $args)
    {
        $post = (array)$request->getParsedBody();

        $amenity = new Amenity;
        $amenity->amenity_desc = $post['unit_name'];
        
        if($amenity->save()) {
            return $response->withStatus(200)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($amenity, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }                    
    }

    public function update($request, $response, $args)
    {
        $post = (array)$request->getParsedBody();

        $amenity = Amenity::where('amenity_id', $args['id'])->first();
        $amenity->amenity_desc = $post['unit_name'];
        
        if($amenity->save()) {
            return $response->withStatus(200)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($amenity, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }
    }

    public function delete($request, $response, $args)
    {
        $amenity = Amenity::where('amenity_id', $args['id'])->first();
        
        if($amenity->delete()) {    
            return $response->withStatus(200)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($amenity, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }
    }
}
