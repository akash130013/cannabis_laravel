<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    

    /**
     * Show the staic terms and condition page of store.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTermsAndCondition()
    {
        return view('Store::static.terms-condition');
    }

    /**
     * Show the staic terms and condition page of store.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPrivacyPolicy()
    {
        return view('Store::static.privacy-policy');
    }

     /**
     *  show Static pages
     * @param :slug of page
     * @return : application/html
     */
    public function showStaticPage(Request $request)
    {
        $slug  = $request->get('slug', 'terms-conditions');
        if($slug)
        {
            $data = StaticPage::where(['slug'=>$slug,'panel'=>'store'])->first();
            if($data)
                return view('Store::static.cms-page',compact('data'));
        }
        return redirect()->route('store.login');

    }
}
