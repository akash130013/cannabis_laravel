<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\StaticPage;

class PageService
{

    public function __construct()
    {
        $this->staticPage = new StaticPage();
    }

    public function getPages(array $param)
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $static_pages = $this->staticPage->select($selectColumn)
            ->when(isset($param['id']), function ($q) use ($param) {
                return $q->where('id', $param['id']);
            })
            ->when(isset($param['slug']), function ($q) use ($param) {
                return $q->where('slug', $param['slug']);
            });

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $static_pages = CommonHelper::restPagination($static_pages->paginate($param['pagesize']));
            } else {
                $static_pages = $static_pages->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $static_pages = $static_pages->get();
        }

        return $static_pages;
    }

}
