<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Ip;
use App\Models\Patient;

class IpController extends Controller
{
    public function getAll($request, $response, $args)
    {
        $conditions = [];
        $page = (int)$request->getQueryParam('page');
        $ward = (int)$request->getQueryParam('ward');

        if(!empty($ward)) array_push($conditions, ['ward' => $ward]);

        $link = 'http://localhost'. $request->getServerParam('REDIRECT_URL');

        if(count($conditions) > 0) {
            $model = Ip::with('patient', 'ward')
                        ->whereNull('dchdate')
                        ->whereNotIn('ward', ['06','11','12'])
                        ->where($conditions);
        } else {
            $model = Ip::with('patient', 'ward')
                        ->whereNull('dchdate')
                        ->whereNotIn('ward', ['06','11','12']);
        }

        $bookings = paginate($model, 'regdate', 10, $page, $link);
        
        $data = json_encode($bookings, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE);

        return $response
                ->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write($data); 
    }
    
    public function getById($request, $response, $args)
    {
        $ip = Ip::where('an', $args['an'])
                ->with('patient')
                ->with('ward:ward,name')
                ->with('pttype:pttype,name')
                ->with('patient.address')
                ->first();

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($ip, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }

    // public function store($request, $response, $args)
    // {
    //     $post = (array)$request->getParsedBody();

    //     $dept = new Unit;
    //     $dept->name = $post['depart_name'];
        
    //     if($dept->save()) {
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($dept, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }                    
    // }

    // public function update($request, $response, $args)
    // {
    //     $post = (array)$request->getParsedBody();

    //     $dept = Unit::where('depart_id', $args['id'])->first();
    //     $dept->name = $post['depart_name'];
        
    //     if($dept->save()) {
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($dept, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }

    // public function delete($request, $response, $args)
    // {
    //     $dept = Unit::where('depart_id', $args['id'])->first();
        
    //     if($dept->delete()) {    
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($dept, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }
}
