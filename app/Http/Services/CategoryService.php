<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\Category;

class CategoryService
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * CategoryService constructor.
     */
    public function __construct()
    {
        $this->category = new Category();
    }

    public function getCategories($param = [])
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $categories = $this->category->select($selectColumn)
            ->when(isset($param['id']), function ($q) use ($param) {
                return $q->where('id', $param['id']);
            })
            ->when(isset($param['name']), function ($q) use ($param) {
                return $q->where('name', 'LIKE', $param['name']);
            })
            ->when(isset($param['status']), function ($q) use ($param) {
                return $q->where('status', $param['status']);
            });

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $categories = CommonHelper::restPagination($categories->paginate($param['pagesize']));
            } else {
                $categories = $categories->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $categories = $categories->get();
        }

        return $categories;

    }


   

}
