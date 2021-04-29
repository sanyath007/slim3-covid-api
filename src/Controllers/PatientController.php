<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Patient;
use App\Models\Registration;
use App\Models\Bed;

class PatientController extends Controller
{
    public function getAll($request, $response, $args)
    {
        $page = (int)$request->getQueryParam('page');
        $dchdate = (int)$request->getQueryParam('dchdate') == '0' ? false : true;
        $ward = $request->getQueryParam('ward') == '' ? false : true;

        $model = Registration::with('patient', 'bed')
                    ->when($dchdate, function($q) {
                        $q->whereNull('dch_date');
                    })
                    ->when($ward, function($q) use ($request) {
                        $q->where('ward', $request->getQueryParam('ward'));
                    })
                    ->orderBy('ward')
                    ->orderBy('reg_date', 'desc');

        $patients = paginate($model, 10, $page, $request);
        
        $data = json_encode($patients, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE);

        return $response
                ->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write($data);
    }
    
    public function getById($request, $response, $args)
    {
        $patient = Registration::where('hn', $args['hn'])->first();

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($patient, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    }

    public function store($request, $response, $args)
    {
        $post = (array)$request->getParsedBody();

        try {
            $patient = new Patient;
            $patient->hn = $post['hn'];
            $patient->cid = $post['cid'];
            $patient->name = $post['name'];
            $patient->sex = $post['sex'];
            $patient->birthdate = $post['birthdate'];
            $patient->age_y = $post['age_y'];
            $patient->tel = $post['tel'];

            if($patient->save()) {
                $reg = new Registration;
                $reg->an = $post['an'];
                $reg->hn = $post['hn'];
                $reg->reg_date = $post['reg_date'];
                $reg->ward = $post['ward'];
                $reg->bed = $post['bed'];
                $reg->code = $post['code'];
                // $reg->lab_date = $post['lab_date'];
                // $reg->lab_result = $post['lab_result'];
                $reg->dx = $post['dx'];
                $reg->symptom = $post['symptom'];
                $reg->reg_from = $post['reg_from'];
                $reg->reg_state = $post['reg_state'];
                $reg->remark = $post['remark'];
                $reg->save();

                Bed::where('bed_id', $post['bed'])->update(['bed_status' => 1]);

                return $response->withStatus(200)
                        ->withHeader("Content-Type", "application/json")
                        ->write(json_encode($patient, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
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

    // public function update($request, $response, $args)
    // {
    //     $post = (array)$request->getParsedBody();

    //     $Patient = Patient::where('Patient_id', $args['id'])->first();
    //     $Patient->name = $post['Patient_name'];
        
    //     if($Patient->save()) {
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($Patient, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }

    // public function delete($request, $response, $args)
    // {
    //     $Patient = Patient::where('Patient_id', $args['id'])->first();
        
    //     if($Patient->delete()) {    
    //         return $response->withStatus(200)
    //                 ->withHeader("Content-Type", "application/json")
    //                 ->write(json_encode($Patient, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE));
    //     }
    // }
}
