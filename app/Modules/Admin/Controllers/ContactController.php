<?php

namespace App\Modules\Admin\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class ContactController extends Controller
{
     /**
     * index
     * @param : null
     * @return : application/json
     */

    public function index(Request $request)
    {
        return view('Admin::contact.index');
    }


}
