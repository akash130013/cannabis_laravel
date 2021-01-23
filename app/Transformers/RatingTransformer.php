<?php


namespace App\Transformers;


use App\Helpers\CommonHelper;
use Illuminate\Support\Arr;

/**
 * transform data-object in human readable json format
 * Class ReviewTransformer
 * @package App\Transformers
 * @author Sumit Sharma
 */
class RatingTransformer
{
    /**
     * transform rating collection
     * @param $ratings
     * @param $noData (optional)
     * @return \Illuminate\Support\Collection
     */
    public static function TransformReviewCollection($ratings, $noData = null)
    {
        $ratingData = collect($ratings['data']);
        if ($noData){
            $ratingData = $ratings;
        }
        return  $ratingData->map(function ($item) {
            $tmpItem                      = new \stdClass();
            $tmpItem->user['id']          = @$item['created_by'];
            $tmpItem->user['name']        = @$item['user']['name'];
            $tmpItem->user['profile_pic'] = @$item['user']['profile_pic'];
            $tmpItem->review              = @$item['review'];
            $tmpItem->rating              = @$item['rate'];
            $tmpItem->created_date        = @CommonHelper::convertFormat($item['created_at'], 'd-M-Y');
            return $tmpItem;
        });
    }

    /**
     * transform rating object
     * @param $rating
     * @return \stdClass
     */
    public static function TransformReviewObject($rating)
    {
            $tmpItem                      = new \stdClass();
            $tmpItem->user['id']          = @$rating->created_by;
            $tmpItem->user['name']        = @$rating->user->name;
            $tmpItem->user['profile_pic'] = @$rating->user->profile_pic;
            $tmpItem->review              = @$rating->review;
            $tmpItem->rating              = @$rating->rate;
            $tmpItem->created_date        = @CommonHelper::convertFormat($rating->created_at, 'd-M-Y');
            return $tmpItem;
    }

}
