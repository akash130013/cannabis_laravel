<?php

namespace App\Http\Controllers\Api\User;

use App\Models\ContactQuery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * @var ContactQuery
     */
    protected $contactQuery;

    /**
     * ContactController constructor.
     * @param ContactQuery $contactQuery
     */
    public function __construct(ContactQuery $contactQuery)
    {
        $this->contactQuery = $contactQuery;
    }


    public function query(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'name' => ['required', 'max:100'],
                'email'=> ['required', 'email', 'max:500'],
                'reason' => "required",
                "message" => ['required']

            ]);
            if ($validator->fails()) {
                return response()->jsend_error(new \Exception($validator->errors()->first()), $message = null);
            }

            $contact = $this->contactQuery->create($request->all());
            if (!$contact)
                return response()->jsend_error(new \Exception("some error occurred"), $message = null);

            return response()->jsend($data = $contact, $presenter = null, $status = "success", $message = trans('Cannabies.querySubmitted'), $code = config('constants.SuccessCode'));


        } catch (\Exception $exception) {
            $error['statusCode'] = $exception->getCode();
            $error['message']    = $exception->getMessage() . ' on ' . $exception->getFile() . ' at ' . $exception->getLine();
            \Log::error('error: ', $error);
            return response()->jsend_error(new \Exception($exception->getMessage()), $message = null, $code = $error['statusCode'] ?? 200);
        }

    }
}
