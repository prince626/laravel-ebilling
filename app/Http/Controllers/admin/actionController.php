<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiHelpers;
use App\Helpers\SendResponse;
use App\Http\Controllers\Controller;
use App\Models\activateaction;
use App\Models\logaction;
use Illuminate\Http\Request;

class actionController extends Controller
{
    public function activateAction()
    {
        $ret = ApiHelpers::ret();
        $findAction = activateaction::all();
        $response = SendResponse::SendResponse($ret, 'Success', $findAction);
        $ret->trace .= 'get_data, ';
        $response = view('admin.activateAction')->with(['action' => $findAction]);
        return $response;
    }
    public function logAction()
    {
        $ret = ApiHelpers::ret();
        $findAction = logaction::all();
        $ret->trace .= 'get_data, ';

        $response = SendResponse::SendResponse($ret, 'Success', $findAction);
        $response = view('admin.logAction')->with(['action' => $findAction]);
        return $response;
    }
}
