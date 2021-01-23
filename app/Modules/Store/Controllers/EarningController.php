<?php

namespace App\Modules\Store\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StoreEarning;

class EarningController extends Controller
{


    public function index(Request $request)
    {
        $condition = [];

        $condition['store_id'] = Auth::guard('store')->user()->id;

        /*
        |
        |check if admin has added commision or not
        |
        */

        // $checkStoreCommissionExists = StoreEarning::checkStoreCommision($condition);
        // // dd($condition); 
        // if(is_null($checkStoreCommissionExists)) {

        //     return view('Store::earning.empty');
            
        // }

        $condition['search'] = $request->has('search') && $request->get('search') != NULL ? $request->get('search'):NULL;
        $condition['start'] = $request->has('start') && $request->get('start') != NULL? date('Y-m-d',strtotime($request->get('start'))) : NULL;

        $condition['end'] = $request->has('end') && $request->get('end') != NULL ? date('Y-m-d',strtotime($request->get('end'))) :NULL;

        $condition['status'] = empty($request->get('status')) ? "" :  $request->get('status');

        $earningList = StoreEarning::getStoreEarningList($condition);
        // dd($earningList);
        $totalEarning = StoreEarning::getStoreEarningAmount($condition);

        $totalOutStanding = StoreEarning::getStoreOutStadingAmount($condition);

        return view('Store::earning.index', compact('earningList', 'totalEarning', 'totalOutStanding'));
    }

    /**
     * 
     * searchEarning
     * @param : search Term
     * @return : application/json
     * 
     */


    public function searchEarning(Request $request)
    {
        $searchTerm = $request->get('q', '');
        $condition = [];
        $condition['search'] = $searchTerm;
        $condition['store_id'] = Auth::guard('store')->user()->id;

        $result = StoreEarning::getEarningByOrder($condition);

        $data = [];

        if ($result->count()) {

            foreach ($result as $key => $row) {
              
                $data[$key]['title'] = $row->order_uid;
            }
        }

        return response()->json(['items' => $data]);
       
    }
}
