<?php

namespace App\Observers;

use App\Helpers\CommonHelper;
use App\Models\Rating;
use App\Modules\Admin\Models\CategoryProduct;

class RatingObserver
{
    /**
     * Handle the rating "created" event.
     *
     * @param  \App\Models\Rating  $rating
     * @return void
     */
    public function created(Rating $rating)
    {
        if ($rating->type == config('constants.ratingType.product')){
            info($rating->rated_id);
            $avgRate = CommonHelper::fetchAvgRating($rating->rated_id, config('constants.ratingType.product'));
            $product = CategoryProduct::find($rating->rated_id);
            $product->avg_rate = $avgRate;
            $product->save();
        }
    }


    /**
     * Handle the rating "updated" event.
     *
     * @param  \App\Models\Rating  $rating
     * @return void
     */
    public function updated(Rating $rating)
    {
        //
    }

    /**
     * Handle the rating "deleted" event.
     *
     * @param  \App\Models\Rating  $rating
     * @return void
     */
    public function deleted(Rating $rating)
    {
        //
    }

    /**
     * Handle the rating "restored" event.
     *
     * @param  \App\Models\Rating  $rating
     * @return void
     */
    public function restored(Rating $rating)
    {
        //
    }

    /**
     * Handle the rating "force deleted" event.
     *
     * @param  \App\Models\Rating  $rating
     * @return void
     */
    public function forceDeleted(Rating $rating)
    {
        //
    }
}
