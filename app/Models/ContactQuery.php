<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactQuery extends Model
{

    
    /**
     * @var array
     */
    protected $guarded = [];

  /**
     * To fetch contact  data list
     *
     * @param int $offset List page number
     * @param int $limit  Total rows on one page
     * @param string $searchLike  search string
     * @param string $orderBy  order by key
     * @return Array|Bolean
     */
    public static function getContactQueryData(int $offset, int $limit, string $searchLike, array $filter)
    {
       $list =  ContactQuery::select('id','name','email','reason','created_at','message')
                                    ->when($searchLike, function($query) use($searchLike)
                                    {
                                        $query->where('name', 'like', '%' . $searchLike . '%')
                                            ->orWhere('email', 'like', '%' . $searchLike . '%');

                                    })
                                    ->when($filter['endDate'], function ($query, $endDate) {
                                        return $query->where('distributors.created_at', '<=', $endDate . config('constants.DATE.END_DATE_TIME'));
                                    })
                                    ->when($filter['startDate'], function ($query, $startDate) {
                                        return $query->where('distributors.created_at', '>=', $startDate . config('constants.DATE.START_DATE_TIME'));
                                    })
                                    ->orderBy('created_at','desc');
                                    
        $contactData['filteredCount'] = $list->count();

        $contactData['data'] = $list->limit($limit)
                                ->offset($offset)
                                ->get();


        $totalCountFields = " SQL_NO_CACHE count(id) total";
        $contactData['totalCount'] = ContactQuery::selectRaw($totalCountFields)->value("total") ?? 0;
        return $contactData;
    }

}
