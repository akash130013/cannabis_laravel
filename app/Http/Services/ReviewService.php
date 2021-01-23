<?php


namespace App\Http\Services;


use App\Models\Rating;
use App\Transformers\RatingTransformer;

class ReviewService
{
    public function getReviewObject($type = null, $id = null)
    {
        $rating = Rating::where(['type' => $type, 'rated_id' => $id])->latest()->first();
        return RatingTransformer::TransformReviewObject($rating);
    }
}
