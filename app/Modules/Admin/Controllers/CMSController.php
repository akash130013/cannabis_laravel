<?php


namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\CannabisLog;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;

class CMSController extends Controller
{

    /**
     * @param : null
     * @return : application/html
     * 
     */

    

     public function index()
     {
        return view('Admin::cms.index');
     }

      /**
     * @show  create or update CMS screen
     * @date 04/11/19
     *      * 
     */
    public function edit($id = null)
    {
        $data='';
        if($id)
        {
            $decryptedId = '';
            try 
            {
              $decryptedId = decrypt($id);
            } 
            catch (\Exception $e) 
            {
                abort(Response::HTTP_NOT_FOUND);
            }
            $data= StaticPage::find($decryptedId);
        }
        return view('Admin::cms.edit',compact('data'));
    }
    

    public function update(Request $request,$id)
    {
        try {
                $data = [
                    'content' => $request->content,
                ];
                DB::transaction(function () use ($data,$id){
                    $staticPage = StaticPage::find($id);
                    $staticPage->update($data);
                });
                return redirect()->route('admin.cms.index')
                        ->with(['message' => trans('Admin::messages.cms_update_success'), 'type' => 'success']);
    
        } catch (QueryException $e) {
            $response = ['code' => $e->getCode(),'message' => $e->getMessage()];
            CannabisLog::create($response);  //inserting logs in the table
            return Redirect::back()->with($response);
        }

    }
}