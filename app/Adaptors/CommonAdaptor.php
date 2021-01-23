<?php
namespace App\Adaptors;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Facade;


final class CommonAdaptor extends Facade
{

    /**
     * This function is used to validate ajax request
     * @param Request $request
     * @return response array
     */

    public static function validateAjax(Request $request)
    {
        $response = [
            'status'=> true,
            'code' => Response::HTTP_OK,
        ];
        if (!$request->ajax()) {

            $response = [
                'status'=> false,
                'code'  => Response::HTTP_FORBIDDEN,
                'msg'   => trans('Admin::messages.no_direct_access'),
            ];
           
        }
        return $response;
    }

    /**
     * This function is used to create comman filters
     * @param Request $request
     * @return Response array
     */

    public static function getFilters(Request $request)
    {
        $draw       = (int) $request->get("draw");
        $offset     = (int) $request->get("start");
        $orderBy    = $request->get("order");
        $search     = $request->get('search')??''; 

        $filter = [
            'status'        => $request->get("status"),
            'startDate'     => $request->get("startDate"),
            'endDate'       => $request->get("endDate"),
        ];
        return [
            'draw'      =>  $draw,
            'offset'    =>  $offset,
            'orderBy'   =>  $orderBy,
            'search'    =>  $search,
            'filter'    =>  $filter
        ];
    }

    /**
     * This function is used to get filtered paginate data
     * @param $offset,$draw,$filteredData,$data
     */

    public static function getFilteredFooter($offset,$draw,$filteredData,$data)
    {
        $result = [
            "draw" => $draw,
            "recordsTotal" => $filteredData['totalCount'],
            "recordsFiltered" => $filteredData['filteredCount'],
            "data" => $data,
        ];
        return $result;
    }
}