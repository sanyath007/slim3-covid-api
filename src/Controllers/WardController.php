<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Ward;
use App\Models\Bed;

class WardController extends Controller
{
    public function getAll($request, $response, $args)
    {
        $wards = Ward::all();

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($wards, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }
    
    public function getById($request, $response, $args)
    {
        $ward = Ward::where('ward_id', $args['id'])->first();

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($ward, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }

    public function getWardBeds($request, $response, $args)
    {
        $status = (int)$request->getQueryParam('status') == '0' ? false : true;

        $beds = Bed::where(['ward' => $args['ward']])
                    ->when($status, function($q) use ($status) {
                        $q->where(['bed_status' => $status]);
                    })
                    ->orderBy('bed_no')
                    ->get();

        $data = json_encode($beds, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE);

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write($data);
    }

    public function store($request, $response, $args)
    {
        try {
            $post = (array)$request->getParsedBody();

            $ward = new Ward;
            $ward->ward_no = $post['ward_no'];
            $ward->ward_name = $post['ward_name'];
            $ward->ward_tel = $post['ward_tel'];
            $ward->ward_head_name = $post['ward_head_name'];
            $ward->ward_head_tel = $post['ward_head_tel'];
            $ward->building = $post['building'];
            $ward->floor = $post['floor'];
            $ward->bed_max = $post['bed_max'];
            
            if($ward->save()) {
                return $response->withStatus(200)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode([
                            'status' => 1,
                            'message' => 'Inserting successfully!!',
                            'ward' => $ward
                        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            } else {
                return $response->withStatus(200)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode([
                            'status' => 0,
                            'message' => 'Something went wrong !!'
                        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            }
        } catch (\Throwable $th) {
            return $response->withStatus(500)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode([
                            'status' => 0,
                            'message' => 'Something went wrong !!'
                        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }
    }

    public function update($request, $response, $args)
    {
        try {
            $post = (array)$request->getParsedBody();

            $ward = Ward::where('ward_id', $args['id'])->first();
            $ward->ward_no = $post['ward_no'];
            $ward->ward_name = $post['ward_name'];
            $ward->ward_tel = $post['ward_tel'];
            $ward->ward_head_name = $post['ward_head_name'];
            $ward->ward_head_tel = $post['ward_head_tel'];
            $ward->building = $post['building'];
            $ward->floor = $post['floor'];
            $ward->bed_max = $post['bed_max'];
            
            if($ward->save()) {
                return $response->withStatus(200)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode([
                            'status' => 1,
                            'message' => 'Updating successfully!!',
                            'ward' => $ward
                        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            } else {
                return $response->withStatus(200)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode([
                            'status' => 0,
                            'message' => 'Something went wrong !!'
                        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
            }
        } catch (\Throwable $th) {
            return $response->withStatus(500)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode([
                            'status' => 0,
                            'message' => 'Something went wrong !!'
                        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }
    }

    public function delete($request, $response, $args)
    {
        $ward = Ward::where('ward_id', $args['id'])->first();
        
        if($ward->delete()) {    
            return $response->withStatus(200)
                    ->withHeader("Content-Type", "application/json")
                    ->write(json_encode($ward, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
        }
    }
}
