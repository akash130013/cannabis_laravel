<?php


namespace App\Transformers;


class UserTransformer
{
    public static function TransformObject($user)
    {
        $tmpItem                      = new \stdClass();
        $tmpItem->id                  = $user->id;
        $tmpItem->name                = $user->name;
        $tmpItem->user_referral_code  = $user->user_referral_code;
        $tmpItem->dob                 = $user->dob;
        $tmpItem->profile_pic         = $user->profile_pic;
        $tmpItem->lat                 = $user->lat;
        $tmpItem->lat                 = $user->lat;
        $tmpItem->lng                 = $user->lng;
        $tmpItem->country_code        = $user->country_code;
        $tmpItem->phone_number        = $user->phone_number;
        $tmpItem->email               = $user->email;
        $tmpItem->location_updated_at = $user->location_updated_at;
        $tmpItem->status              = $user->status;
        $tmpItem->referred_by         = $user->referred_by;
        $tmpItem->is_email_verified   = isset($user->email_verified_at) ? true : false;
        $tmpItem->net_loyaltyPoints   = $user->loyaltyPoints->last()->net_amount ?? 0;
        $tmpItem->user_proof          = $user->userProof->pluck('file_url');
        $tmpItem->push_status          = $user->push_status;
        return $tmpItem;
    }
}
