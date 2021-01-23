<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class Notification extends Model
{
     /**
     * The function is to use soft delete of data
     */

    use SoftDeletes;
    protected $fillable = ['notify_type','notify_type_id','title','description','url','platform'];


     /*
     * Column Position in data table
     */
    protected static $storeTableDataSort = [
        1 => "created_at",
        2 => "platform",
    ];

      /**
     * To fetch store data list
     *
     * @param int $offset List page number
     * @param int $limit  Total rows on one page
     * @param string $searchLike  search string
     * @param string $orderBy  order by key
     * @return Array|Bolean
     */
    public static function getNotificationData(int $offset, int $limit, string $searchLike, array $orderBy, array $filter)
    {
         $orderColumn = self::$storeTableDataSort[$orderBy['column']];

        $storeData['data'] = Notification::select('id','created_at','platform','description')
                                ->orderBy($orderColumn, $orderBy['dir'])
                                ->when($searchLike,function($query,$searchLike)
                                {
                                    $query->where('description', 'like', '%' . $searchLike . '%');
                                })
                                ->when($filter['status'], function ($query, $status) {
                                    return $query->where('platform', $status);
                                })
                                ->when($filter['endDate'], function ($query, $endDate) {
                                    return $query->where('created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
                                })
                                ->when($filter['startDate'], function ($query, $startDate) {
                                    return $query->where('created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
                                });
        $result                     = $storeData['data']->get();
        $storeData['filteredCount'] = Notification::selectRaw("FOUND_ROWS() total")->value("total") ?? 0;

        $storeData['data']          = $storeData['data']->offset($offset)
                                                ->limit($limit)
                                                ->get();
        $totalCountFields        = "SQL_NO_CACHE count(id) total";
        $storeData['totalCount'] = Notification::selectRaw($totalCountFields)->value("total") ?? 0;
        return $storeData;
    }

}
