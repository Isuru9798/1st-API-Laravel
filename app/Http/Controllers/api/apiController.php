<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\RegisterDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class apiController extends Controller
{
    public function getInitialStatus(Request $request)
    {
        $res = [];
        $macAddress = $request->get('mac-address');
        
        if ( empty($macAddress)) {
            return response()->json('record not found!', 400);
        }
        $data = RegisterDetails::where('macAddress', $macAddress)->select('timestamp')->first();
        if ( !empty($data)) {
            $to = Carbon::parse($data->timestamp);
            $from = Carbon::now();
            $timeDiff = $to->diffInMinutes($from);
            if (($timeDiff / 60) > 24) {
                $res = [
                    'winningPoints' => mt_rand(50, 100),
                    'winningAmmount' => mt_rand(50, 100),
                    'maxTime'=> true
                ];
            } else {
                $res = [
                    'winningPoints' =>mt_rand(50, 100),
                    'winningAmmount' => mt_rand(50, 100),
                    'maxTime'=> false
                ];
            }
            return response()->json($res, 200);
        } else {
            return response()->json('Record not found', 400);
        }
    }
    
    public function record(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobileNumber' => $request->mobileNumber,
            'macAddress' => $request->deviceInfo['mac-address'],
            'deviceId' => $request->deviceInfo['deivceId'],
            'imiNumber' => $request->deviceInfo['imiNumber'],
            'timestamp' => Carbon::now()
        ];

        ######################## Validate Data ########################

        $rules = [
            'name' => 'required',
            'mobileNumber' => 'required',
            'macAddress' => 'required',
            'deviceId' => 'required',
            'imiNumber' => 'required',
        ];
        $messages = [
            'name.required' => 'Please enter a name.',
            'mobileNumber.required' => 'Please enter a mobile number.',
            'macAddress.required' => 'MAC Address not found.',
            'deviceId.required' => 'Device Id not found.',
            'imiNumber.required' => 'IMI Number not found.'
        ];
        $validate = Validator::make($data, $rules, $messages);

        if ($validate->fails()) {
            return response()->json($validate->messages(), 400);
        }
        ######################## Validate End ########################


        ######################## Insert Data ########################
        $data = RegisterDetails::create($data);

        $data = [
            'id' => $data->id,
            'name' => $data->name,
            'email' => $data->email,
            "mobileNumber" => $data->mobileNumber,
            "deviceInfo" => [
                "mac-address" =>$data->macAddress,
                "deivceId" =>$data->deviceId,
                "imiNumber" => $data->imiNumber,
            ]
        ];
        return response()->json($data, 201);
    }

    ############ if you want get mac address using php ################
    // public function MAC()
    // {
    //     ob_start();
    //     system('ipconfig/all');
    //     $mycom = ob_get_contents();
    //     ob_clean();
    //     $findme = "Physical";
    //     $pmac = strpos($mycom, $findme);
    //     $mac = substr($mycom, ($pmac + 36), 17);
    //     return $mac;
    // }
}
