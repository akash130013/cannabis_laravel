<?php

namespace App\Modules\Admin\Controllers;

use App\Helpers\CommonHelper;
use App\Store;
use App\Modules\Store\Models\StoreDeliveryAddress;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\CannabisLog;
use App\Modules\Store\Models\StoreProofs;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * index
     * @param : null
     * @return : application/html
     */

    public function index(Request $request)
    {
        $productId = $request->query('product_id') ?? '';
        if ('' != $productId) {
            try {
                $productId = decrypt($request->query('product_id')) ?? '';
            } catch (QueryException $e) {
                abort(Response::HTTP_NOT_FOUND);
            }
        }
        return view('Admin::store.index', ['productId' => $productId]);
    }

    /**
     * To show requested store 
     * @param :  null
     * @return : application/html
     * 
     */

    public function showRequestedStoreData()
    {
        return view('Admin::store.requested-list');
    }

    /**
     * To show store  details 
     * @param :  null
     * @return : application/html with data
     */

    public function show($id)
    {
        try {
            try {
                $decryptId = decrypt($id);
            } catch (QueryException $e) {
                abort(Response::HTTP_NOT_FOUND);
            }
            $data = Store::withCount('distributors', 'completedOrders', 'storeProducts')->find($decryptId);
            $proof = StoreProofs::where('store_id', $data->id)->first();
            // dd($proof);
            if ($data) {
                [$amount_pending, $total_earning, $last_settlement] = CommonHelper::storeEarning($decryptId);
                $data->load('storeDetail', 'commission', 'storeImages');
                $data->store_encrypt_id  = encrypt($data->id);
                $data->avtaar            = $data->avatar ?? config('constants.DEAFULT_IMAGE.STORE_IMAGE');
                $data->store_name        = $data->storeDetail ? $data->storeDetail->store_name : '';
                $data->address           = $data->storeDetail ? $data->storeDetail->formatted_address : '';
                $data->amount_pending    = $amount_pending;
                $data->total_earning     = $total_earning;
                $data->proof_url = $proof->fileurl;
                
                return view('Admin::store.show', compact('data'));
            }
            abort(Response::HTTP_NOT_FOUND);
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(), 'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return redirect()->back()->with(['message' => trans('Admin::messages.error'), 'type' => 'error']);
        }
    }

    /**
     * To get delivery locations 
     * @param :  id (optional)
     * @return : application/json
     */

    public function getDeliverLocations($id = null)
    {
        if (null != $id) {
            $locations = StoreDeliveryAddress::select('formatted_address')->where('store_id', decrypt($id))->get();
            return response()->json($locations, Response::HTTP_OK);
        }
        abort(Response::HTTP_NOT_FOUND);
    }

    /***
     * showOpenSettlement function to show open settlement of the store
     * @request : encrypted store id and store name
     * @return : application/HTML
     */
    public function showOpenSettlement($encryptId, $store_name)
    {
        return view('Admin::store.open-settlement', ['encryptId' => $encryptId, 'store_name' => $store_name]);
    }

    /***
     * showStoreSettlementHistory function to show settlement history of the store
     * @request : encrypted store id and store name
     * @return : application/HTML
     */
    public function showStoreSettlementHistory($encryptId, $store_name)
    {
        return view('Admin::store.history-settlement', ['encryptId' => $encryptId, 'store_name' => $store_name]);
    }
}
