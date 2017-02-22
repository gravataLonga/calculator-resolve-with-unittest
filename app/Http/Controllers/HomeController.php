<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Calculator\Calculator;
use App\Models\Operation;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    	return view('calculator');
    }

    public function calc(Request $request)
    {

    	$strOperation = $request->input('calc');
    	$strIp = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    	$intBonusNumber = rand(0, 100);
    	$booBonus = false;
    	$intUnixTimestamp = Carbon::now()->timestamp;
    	$hasError = false;

    	$calc = new Calculator;
    	$calc->set($strOperation);
    	$strResult = $calc->calculate();

    	$booBonus = $intBonusNumber == $strResult;



    	$operator = new Operation;
    	$operator->ip = $strIp;
    	$operator->datetime = $intUnixTimestamp;
    	$operator->operation = $strOperation;
    	$operator->result = $strResult == null ? 0 : $strResult;
    	$operator->bonus = $booBonus;

    	if(!$operator->save()) {
    		$hasError = true;
    	}

    	if ($strResult == null) {
    		$hasError = true;
    	}

		return response()->json([
			'bonus' => $booBonus,
			'error' => $hasError,
			'result' => $strResult == null ? 'Not divised' : $strResult
		]);	
    }
}
