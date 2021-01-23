<?php

namespace App\Http\Controllers;

use App\Http\Services\PageService;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    /**
     * @var pageService
     */
    protected $pageService;

    /**
     * CmsController constructor.
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }


    public function staticPage()
    {
    
//        return Route::current()->uri;
        $slug =  Str::after(Route::current()->uri, "api/") ;
        $page = $this->pageService->getPages(['slug' => $slug])->first();
        if (!$page){
            abort(404);
        }
        return view('static-page.static-page-show', compact('page'));

    }

    /**
     * showExteriorHelpPage
     * @param : null
     * @return : application/html 
     */

    public function showExteriorHelpPage()
    {
        $data= StaticPage::where(['slug'=>'help','panel'=>'user'])->first(); 
        return view('User::settings.exterior-static-page.help',compact('data'));
    }


}
