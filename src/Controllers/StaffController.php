<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Person;

class StaffController extends Controller
{
    public function getAll($request, $response, $args)
    {
        $staff = Person::all();

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($Person, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }
    
    public function getById($request, $response, $args)
    {
        $staff = Person::where('person_id', $args['id'])->first();

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($staff, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }

    // public function store($request, $response, $args)
    // {
    //     $post = (array)$request->getParsedBody();

    //     $staff = new Person;
    //     $staff->name = $post['person_name'];
        
    //     if($staff->save()) {
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($staff, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }                    
    // }

    // public function update($request, $response, $args)
    // {
    //     $post = (array)$request->getParsedBody();

    //     $staff = Person::where('person_id', $args['id'])->first();
    //     $staff->name = $post['person_name'];
        
    //     if($staff->save()) {
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($staff, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }

    // public function delete($request, $response, $args)
    // {
    //     $staff = Person::where('person_id', $args['id'])->first();
        
    //     if($staff->delete()) {    
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($staff, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }
}
