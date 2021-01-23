<?php


namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\CategoryProduct;
use App\Modules\Admin\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Models\PromoCode;
use App\Models\Distributor;
use App\AdminDeliveryAddress;
use App\Helpers\CommonHelper;
use App\Jobs\PushNotification;
use App\Models\StoreEarning;
use App\Modules\Admin\Models\Notification;
use App\Modules\Store\Models\StoreProductStock;
use App\Store;
use DB;
use Illuminate\Database\QueryException;

class CommonAjaxController extends Controller
{

    /**
     * To change data status in DB
     *
     * @param Request $request
     */
    public function changeDataStatus(Request $request)
    {

        $flag = false;
        //Check is request is Ajax
        if (1 != $request->ajax()) {
            $responseArray = [
                'code' => Response::HTTP_FORBIDDEN,
                'msg' => trans('Admin::messages.no_direct_access'),
            ];

            return (new Response($responseArray, Response::HTTP_FORBIDDEN))
                ->header('Content-Type', 'application/json');
        } // End Check
        try {

            $url = '';

            switch ($request->type) {
                case 'product':
                    $product_id = decrypt($request->id);
                    $status     = config('constants.STATUS.ACTIVE');
                    $message    = trans('Admin::messages.unblock_product');
                    if ($request->toChange == config('constants.BLOCKED')) {
                        $status     = config('constants.STATUS.BLOCKED');
                        $message    = trans('Admin::messages.block_product');
                    }

                    if ($request->toChange == config('constants.DELETED')) {
                        $status     = config('constants.STATUS.DELETED');
                        $message    = trans('Admin::messages.delete_product_success');
                    }

                    $dataToUpdate = [
                        "status" => $status,
                    ];
                    $flag = CategoryProduct::where('id', $product_id)->update($dataToUpdate);
                    break;

                case 'category':
                    $category_id = decrypt($request->id);
                    $status     = config('constants.STATUS.ACTIVE');
                    $message    = trans('Admin::messages.unblock_category');
                    if ($request->toChange == config('constants.BLOCKED')) {
                        $status     = config('constants.STATUS.BLOCKED');
                        $message    = trans('Admin::messages.block_category');
                    }
                    if ($request->toChange == config('constants.DELETED')) {
                        $status     = config('constants.STATUS.DELETED');
                        $message    = trans('Admin::messages.delete_category');
                    }

                    $dataToUpdate = [
                        "status" => $status,
                    ];
                    $flag = Category::where('id', $category_id)->update($dataToUpdate);
                    //   CategoryProduct::where('category_id',$category_id)->update($dataToUpdate);

                    break;

                case 'user':
                    $user_id    = decrypt($request->id);
                    $flag       = 'OK';
                    if ($request->toChange == config('constants.DELETED')) {
                        $message    = trans('Admin::messages.delete_user');
                        $flag       = User::find($user_id)->delete();
                    } else {
                        $status     = config('constants.STATUS.ACTIVE');
                        $message    = trans('Admin::messages.unblock_user');
                        if ($request->toChange == config('constants.BLOCKED')) {
                            $status     = config('constants.STATUS.BLOCKED');
                            $message    = trans('Admin::messages.block_user');
                        }
                        $dataToUpdate = [
                            "status" => $status,
                        ];
                        $flag = User::where('id', $user_id)->update($dataToUpdate);
                    }
                    break;

                case 'store':
                    $store_id   = decrypt($request->id);
                    $flag       = 'OK';
                    if ($request->toChange == config('constants.DELETED')) {
                        $message    = trans('Admin::messages.delete_store');
                        $flag       = Store::find($store_id)->delete();
                    } elseif ($request->toChange == config('constants.APPROVED')) {
                        $status     = config('constants.STATUS.APPROVE');
                        $message    = trans('Admin::messages.approve_store');
                        $dataToUpdate = [
                            'is_admin_approved' => true,
                            'admin_action'      => $status
                        ];
                        $flag = Store::where('id', $store_id)->update($dataToUpdate);
                        StoreProductStock::where('store_id', $store_id)->update(['status' => config('constants.STATUS.ACTIVE')]);
                    } elseif ($request->toChange == config('constants.REJECTED')) {
                        $status     = config('constants.STATUS.REJECT');
                        $message    = trans('Admin::messages.reject_store');
                        $dataToUpdate = [
                            'is_admin_approved' => false,
                            'admin_action'      => $status,
                            'status'            => config('constants.STATUS.BLOCKED')
                        ];
                        $flag = Store::where('id', $store_id)->update($dataToUpdate);
                    } else {
                        $status     = config('constants.STATUS.ACTIVE');
                        $message    = trans('Admin::messages.unblock_store');
                        if ($request->toChange == config('constants.BLOCKED')) {
                            $status     = config('constants.STATUS.BLOCKED');
                            $message    = trans('Admin::messages.block_store');
                        }
                        $dataToUpdate = [
                            "status" => $status,
                        ];
                        $flag = Store::where('id', $store_id)->update($dataToUpdate);
                    }
                    break;
                case 'promocode':
                    $promocode_id   = decrypt($request->id);
                    $flag           = 'OK';
                    if ($request->toChange == config('constants.DELETED')) {
                        $message    = trans('Admin::messages.delete_promocode');
                        $flag       = PromoCode::find($promocode_id)->delete();
                    } else {
                        $status     = config('constants.STATUS.ACTIVE');
                        $message    = trans('Admin::messages.active_promocode');
                        if ($request->toChange == config('constants.BLOCKED')) {
                            $status     = config('constants.STATUS.INACTIVE');
                            $message    = trans('Admin::messages.inactive_promocode');
                        }
                        $dataToUpdate = [
                            "offer_status" => $status,
                        ];
                        $flag = PromoCode::where('id', $promocode_id)->update($dataToUpdate);
                    }
                    break;
                case 'distributor':
                    $distributor_id = decrypt($request->id);
                    $flag           = 'OK';
                    $dataToUpdate   = [];
                    if ($request->toChange == config('constants.DELETED')) {
                        $message    = trans('Admin::messages.delete_distributor');
                        $flag       = Distributor::find($distributor_id)->delete();
                    } else {
                        $status     = config('constants.STATUS.ACTIVE');
                        $message    = trans('Admin::messages.active_distributor');
                        $distributor = Distributor::find($distributor_id);
                        if ($request->toChange == config('constants.BLOCKED')) {
                            $status                 = config('constants.STATUS.BLOCKED');
                            $message                = trans('Admin::messages.inactive_distributor');
                            $distributor->status    = $status;
                            $distributor->tokens()->each(function ($token) {
                                $token->delete();
                            });
                        }
                        $distributor->admin_status = $status;
                        $distributor->save();
                    }
                    break;
                case 'distributor_location':
                    $location_id = decrypt($request->id);
                    $flag           = 'OK';
                    $status         = config('constants.STATUS.ACTIVE');
                    $message        = trans('Admin::messages.active_distributor_location');
                    $location = AdminDeliveryAddress::find($location_id);
                    if ($request->toChange == config('constants.BLOCKED')) {
                        $status     = config('constants.STATUS.BLOCKED');
                        $message    = trans('Admin::messages.inactive_distributor_location');
                        CommonHelper::deactivateStoreDelieveryLocation($location->zipcode);
                    }

                    $location->status = $status;
                    $location->save();
                    break;
                case 'notification':
                    $notification_id    = decrypt($request->id);
                    $flag               = 'OK';
                    $message            = trans('Admin::messages.active_distributor_location');
                    if ($request->toChange == config('constants.NOTIFICATION.REPEAT')) {
                        $message    = trans('Admin::messages.repeat_notification');
                        $notification = Notification::find($notification_id);
                        PushNotification::dispatch($notification);
                    } else if ($request->toChange == config('constants.DELETED')) {
                        Notification::find($notification_id)->delete();
                        $message    = trans('Admin::messages.delete_notification');
                    }
                    break;

                case 'settlement':
                    $settlement_id  = decrypt($request->id);
                    $flag           = 'OK';
                    $message        = trans('Admin::messages.error');
                    if ($request->toChange == config('constants.SETTLEMENT.CLOSED')) {
                        $status  = config('constants.STATUS.CLOSED');
                        $message = trans('Admin::messages.closed_settlement');
                        $data    = [
                            'status'        => $status,
                            'settlement_at' => now(),
                        ];
                        StoreEarning::where('id', $settlement_id)->update($data);
                    }
                    break;

                default:
                    break;
            }

            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $reponse = [
                "MSG" => trans('Admin::messages.error'),
                "CODE" => Response::HTTP_INTERNAL_SERVER_ERROR,

            ];
            if ($flag) {
                $code = Response::HTTP_OK;
                $reponse = [
                    "MSG" => $message,
                    "CODE" => Response::HTTP_OK,
                    'url' => $url,
                ];
            }
            return (new Response($reponse, $code))
                ->header('Content-Type', 'application/json');
        } catch (QueryException $ex) {
            //if any exception catched
            $reponse = [
                "MSG" => $ex->getMessage(),
                "CODE" => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
            return (new Response($reponse, Response::HTTP_INTERNAL_SERVER_ERROR))
                ->header('Content-Type', 'application/json');
        }
    }

    /**
     * @desc used to delete file from s3
     * @date 3 oct
     */
    public function deleteFileS3(Request $request)
    {
        $type = $request->type;
        $flag = false;
        $id = decrypt($request->id);
        try {
            switch ($type) {
                case 'category':
                    $flag = Category::where('id', $id)->update(['thumb_url' => null]);
                    break;
                case 'cat_img':
                    $flag = Category::where('id', $id)->update(['image_url' => null]);
                    break;
                default:
                    # code...
                    break;
            }

            if ($flag) {
                $code = Response::HTTP_OK;
                $reponse = [
                    "code" => Response::HTTP_OK,
                    'msg' => 'Image deleted',
                ];
            } else {
                $code = Response::HTTP_NOT_FOUND;
                $reponse = [
                    "code" => Response::HTTP_NOT_FOUND,
                    'msg' => 'Image deleted',
                ];
            }
            return (new Response($reponse, $code))
                ->header('Content-Type', 'application/json');
        } catch (QueryException $ex) {
            //if any exception catched
            $reponse = [
                "MSG" => $ex->getMessage(),
                "CODE" => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
            return (new Response($reponse, Response::HTTP_INTERNAL_SERVER_ERROR))
                ->header('Content-Type', 'application/json');
        }
    }
}
