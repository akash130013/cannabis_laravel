<?php


namespace App\Modules\Store\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StoreDeliveryAddress extends Model
{
  protected $table = "store_delivery_locations";

  const LIMIT = 10;

  protected $fillable = [
    'formatted_address', 'store_id', 'lat', 'lng', 'status','zip_code'
  ];

  /**
   * getLocationList
   */

  public static function getLocationList($condition = [])
  {

    $deliveryAddresses =  StoreDeliveryAddress::where('store_id', $condition['store_id'])
              ->orderBy('id', 'desc')
              ->where(function ($query) use ($condition) {
                if (!empty($condition['search'])) {
                  $query->where('formatted_address', 'like', '%' . $condition['search'] . '%');
                }
                if (!empty($condition['status'])) {
                  $query->Where('status', $condition['status']);
                }
              })
              ->paginate(self::LIMIT);
                    $deliveryAddresses->map(function($item)
                      {
                        $item->encrypt_id = encrypt([$item->id,$item->status]);
                      });
    return $deliveryAddresses;
  }

  /**
   * getStoreDeliveryAddress
   * @param : condition array
   * @return : record array
   */

   public static function getStoreDeliveryAddress($condition) 
   {

      $query = StoreDeliveryAddress::where('store_id', Auth::guard('store')->user()->id)
                ->where('formatted_address', 'like', '%' .$condition['search'] . '%')
                ->get();
      return $query;


   }
}
