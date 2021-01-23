<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $guarded = [];

    /*
     * Column Position in data table
     */
    protected static $storeTableDataSort = [
        1 => "static_pages.name",
    ];

      /**
     * To fetch user data list
     *
     * @param int $offset List page number
     * @param int $limit  Total rows on one page
     * @param string $searchLike  search string
     * @param string $orderBy  order by key
     * @return Array|Bolean
     */
    public static function getCMSData(int $offset, int $limit, string $searchLike, array $filter)
    {
        $selectFields = " SQL_CALC_FOUND_ROWS 
        static_pages.id,
        static_pages.name, 
        static_pages.slug,
        static_pages.content,
        static_pages.panel,
        static_pages.status";

        //  $orderColumn = self::$storeTableDataSort[$orderBy['column']];

        $cmsData['data'] = StaticPage::selectRaw($selectFields)
                            ->where(function ($query) use ($searchLike) {
                                $query->when($searchLike,
                                    function ($query, $searchLike) {
                                        $query->Where('static_pages.name', 'like', '%' . $searchLike . '%');
                                    });
                            })
                            // ->orderBy($orderColumn, $orderBy['dir'])
                            ->offset($offset)
                            ->limit($limit)
                            ->get();
        $cmsData['filteredCount'] = StaticPage::selectRaw("FOUND_ROWS() total")->value("total") ?? 0;
        $totalCountFields = "SQL_NO_CACHE count(id) total";
        $cmsData['totalCount'] = StaticPage::selectRaw($totalCountFields)->value("total") ?? 0;
        return $cmsData;
    }
}
