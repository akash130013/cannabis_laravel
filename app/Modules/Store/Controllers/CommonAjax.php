<?php


namespace App\Modules\Store\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Store\Models\StoreProductStock;
use App\User;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Notifications\SendSignoutOtpNotification;
use App\Store;
use Illuminate\Support\Facades\Auth;

class CommonAjax extends Controller
{

    public function changeStatus(Request $request)
    {

        try {

            switch ($request->type) {
                case 'product':
                    $reponse = [
                        "MSG" => trans('Store::home.pending_approval_error'),
                        "CODE" => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'url' => $request->url,
                        'message' => trans('Store::home.pending_approval_error')
                    ];
                    if (Auth::guard('store')->user()->admin_action != config('constants.STATUS.PENDING')) {
                        $product_id     = $request->id;
                        $storeProduct   = StoreProductStock::find($product_id);
                        $storeProduct->load('product.getCategory');
                        if ($storeProduct->product->status == config('constants.STATUS.BLOCKED')  || $storeProduct->product->getCategory->status == config('constants.STATUS.BLOCKED')) {
                            $reponse = [
                                "MSG"       => trans('Store::home.product_blocked_by_admin'),
                                "CODE"      => Response::HTTP_UNPROCESSABLE_ENTITY,
                                'url'       => $request->url,
                                'message'   => trans('Store::home.product_blocked_by_admin')
                            ];
                            break;
                        }
                        $message                = trans('Admin::messages.unblock_product');
                        $storeProduct->status   = $request->status;
                        $storeProduct->save();
                        $status = $storeProduct->status == config('constants.STATUS.BLOCKED') ? 'deactivated' : 'activated';
                        $reponse = [
                            "MSG"       => $message,
                            "CODE"      => Response::HTTP_OK,
                            'url'       => $request->url,
                            'message'   => sprintf(trans('Store::home.status_updated_product'), $status)
                        ];
                    }
                    break;

                default:
                    $reponse = [
                        "MSG" => trans('Admin::messages.error'),
                        "CODE" => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'message' => trans('Admin::messages.error')
                    ];
                    break;
            }
        } catch (Exception $ex) {

            $reponse = [
                "MSG" => $ex->getMessage(),
                "CODE" => $ex->getCode(),
            ];
        }

        return response()->json($reponse);
    }

    /**
     * sendEmailNotification
     * @param : email,
     * @return : application/json
     */

    public function sendEmailNotification(Request $request)
    {

        try {

            $email = $request->get('email', '');

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception(trans('Store::home.email_not_found'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $storeId = Auth::guard('store')->user()->id;
            $IsExistingEmail = Store::where('email', $email)->where('id', '<>', $storeId)->first();

            if (!empty($IsExistingEmail)) {

                throw new Exception(trans('Store::home.email_not_found'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = new User();
            $user->email = $email;
            $otp = mt_rand(100000, 999999);
            $user->notify(new SendSignoutOtpNotification($otp));

            $params['otp'] = hash('sha256', $otp);
            $params['email'] = $email;

            $reponse = [
                'code' => Response::HTTP_OK,
                'message' => trans('Store::home.email_otp_send'),
                'data' => $params
            ];
        } catch (Exception $e) {
            $reponse = ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }

        return response()->json($reponse);
    }
}
