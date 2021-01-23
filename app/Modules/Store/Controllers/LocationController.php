<?php


namespace App\Modules\Store\Controllers;

use App\AdminDeliveryAddress;
use App\Http\Controllers\Controller;
use App\Modules\Store\Libraries\HomeLibrary;
use App\Modules\Store\Models\HomeConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Modules\Store\Models\StoreDeliveryAddress;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;


class LocationController extends Controller
{


  protected $storeID;

  const ACTIVE  = 'active';

  const BLOCKED = 'blocked';

  /**
   * index
   * @param : null
   * @return : application/html
   */

  public function index(Request $request)
  {

    $this->storeID = Auth::guard('store')->user()->id;

    $condition = [];
    $condition['search'] = $request->get('search', '');
    $condition['status'] = $request->get('status', '');
    $condition['store_id'] = $this->storeID;
    $condition['page']=$request->input('page','');
 
    $result =  StoreDeliveryAddress::getLocationList($condition);
    
    return view('Store::location.store-location', ['deliveryaddress' => $result]);
  }

  /**
   * storeSubmitStoreDeliveryAddress
   * @param : null
   * @return redirect to product dashboard
   */

  public function storeSubmitStoreDeliveryAddress(Request $request)
  {
            
      $rules = [
                'address'     => 'required',
                'postal_code' => 'required',
                'lat'         => 'required',
                'lng'         => 'required',
              ];

    $validation = Validator::make($request->all(), $rules);

    if ($validation->fails()) {
      return Redirect::back()->with('errors', $validation->errors())->withInput();
    }


    try
    {
      $zipcode = $request->get('postal_code','');

      $storeDeliveryAddress = StoreDeliveryAddress::where('store_id',Auth::guard('store')->user()->id)
                                                  ->where('zip_code',$zipcode)->first();
      if('' == $storeDeliveryAddress)
      {
        $storeDeliveryAddress = new StoreDeliveryAddress;
      }
      // $storeDeliveryAddress                     = StoreDeliveryAddress::firstOrNew(['zip_code' => $zipcode]);
      $storeDeliveryAddress->store_id           = Auth::guard('store')->user()->id;
      $storeDeliveryAddress->formatted_address  = $request->get('address');
      $storeDeliveryAddress->zip_code           = $request->get('postal_code', '');
      $storeDeliveryAddress->lat                = $request->get('lat');
      $storeDeliveryAddress->lng                = $request->get('lng');
      $storeDeliveryAddress->save();

      $response  = ['code' => Response::HTTP_OK,'message' => trans('Store::home.delivery_address_added')];

    } catch (QueryException $e) {

      $response = [
        'code' => $e->getCode(),
        'message' => $e->getMessage()
      ];

      Log::error('DB ERROR : ', $response);
    }

    return redirect()->route('store.location.list')->with('success',$response);
  }

  /**
   * updateLocationStatus
   * @param : null
   * @return : application/json
   */

  public function updateLocationStatus(Request $request)
  {


    try {

      $status = self::BLOCKED;
      $statusRequest = $request->get('status');
      $id     = $request->get('id');

      if (empty($status)) {
        throw new Exception(trans('Store::home.status_required'), Response::HTTP_UNPROCESSABLE_ENTITY);
      }


      if (filter_var($statusRequest, FILTER_VALIDATE_BOOLEAN)) {
        $status = self::ACTIVE;
      }

      $storeDeliveryAddress = StoreDeliveryAddress::find($id);
      $storeDeliveryAddress->status = $status;
      $storeDeliveryAddress->save();

      $http_response_header  = ['code' => Response::HTTP_OK, 'message' => trans('Store::home.status_updated')];

    } catch (QueryException $e) {
      $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
      Log::error('DB ERROR:', $http_response_header);
    } catch (Exception $e) {
      $http_response_header = ['code' => $e->getCode(), 'message' => $e->getMessage()];
    }

    return response()->json($http_response_header);
  }

  /**
   * getDeliveryAddressZipcodes
   * @param : query string
   * @return : application/json
   */

  public function getDeliveryAddressZipcodes(Request $request)
  {

    try {

        $storeId = Auth::guard('store')->user()->id;

      /*
      |
      | show user list of zip codes from uploaded address.
      |
      */

      $condition = [];
      $condition['search'] = $request->get('q', '');

      $zipAddress = AdminDeliveryAddress::showDeliveryZips($condition);

      if (empty($zipAddress)) {

        return response()->json(['value' => '', 'id' => '']);
      }

      $data = array();

        $storeDeliveryAddressZipCode = StoreDeliveryAddress::where('store_id', $storeId)->pluck('zip_code')->toArray();

      foreach ($zipAddress as $row) {
          if (!in_array($row->zipcode, $storeDeliveryAddressZipCode)){
              $data[] = array(
                  'value' => $row->city.' ,'.$row->state.' ,'.$row->country.','.$row->zipcode,
                  'address' => $row->city.' ,'.$row->state.' ,'.$row->country,
                  'zipcode' => $row->zipcode,
                  'id' => $row->id
              );
          }
      }
      $http_response_header = $data;

    } catch (QueryException $e) {
      $http_response_header = ['code' => $e->getCode(), 'messages' => $e->getMessage()];
    }

    return response()->json($http_response_header);
  }


  /**
   * searchLocation
   * @param : query string
   * @return : application/json
   */

   public function searchLocation(Request $request)
   {
       $searchTerm = $request->get('q','');
       
       $condition = [];
       $condition['search'] = $searchTerm;
       $result = StoreDeliveryAddress::getStoreDeliveryAddress($condition);

       $data = [];

       if($result->count()) {


          foreach($result as $key => $row) {

            $data[$key]['title'] = $row->formatted_address;

          }

       }

       return response()->json(['items' => $data]);

   }



}
