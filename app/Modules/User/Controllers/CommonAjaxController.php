<?php


namespace App\Modules\User\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Store\Models\StoreProductStock;
use App\User;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\User\Models\UserProof;
use Illuminate\Support\Facades\Auth;

class CommonAjaxController extends Controller
{

    public function changeStatus(Request $request)
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

            switch ($request->type) {
                case 'product':
                    $product_id = $request->id;
                    $message = trans('Admin::messages.unblock_product');
                    $dataToUpdate = [
                        "status" => $request->toChange,
                    ];
                    $flag = StoreProductStock::where('id', $product_id)->update($dataToUpdate);
                    break;
                default:
                    break;
            }

            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $reponse = [
                "MSG" => trans('Admin::messages.error'),
                "CODE" => Response::HTTP_UNPROCESSABLE_ENTITY,

            ];

            if ($flag) {
                $code = Response::HTTP_OK;
                $reponse = [
                    "MSG" => $message,
                    "CODE" => Response::HTTP_OK,
                    'url' => $request->url,
                ];
            }
        } catch (Exception $ex) {
            //if any exception catched
            return CommonHelper::catchException($ex);
        }

        return response()->json($reponse);
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
        $user_id=Auth::guard('users')->user()->id;
   
        try {
            switch ($type) {
                case 'verification_image':
                    $flag = UserProof::where('id', $id)->delete();
                    // User::where('id', $user_id)->update(['is_proof_completed' =>1]);
                    break;
                default:
                    # code...
                    break;
            }

            if (empty($flag)) {
                throw new Exception(trans('User::home.failed_to_delete'), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $reponse = [
                "code" => Response::HTTP_OK,
                'message' => trans('User::home.image_deleted'),
            ];
        } catch (Exception $ex) {
            //if any exception catched
            return CommonHelper::catchException($ex);
        }
        return response()->json($reponse);
    }
}
