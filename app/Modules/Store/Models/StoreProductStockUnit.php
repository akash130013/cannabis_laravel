<?php


namespace App\Modules\Store\Models;

use Illuminate\Database\Eloquent\Model;

class StoreProductStockUnit extends Model
{
    protected $table = "store_product_stock_units";

    protected $fillable = [
      'stock_id','unit','quant_unit','price','total_stock','status','actual_price','offered_price'
    ];

    public function storeProductStock()
    {
        return $this->hasMany(StoreProductStock::class,'id','stock_id');
    }


}
