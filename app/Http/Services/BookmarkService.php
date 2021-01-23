<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\Bookmark;

class BookmarkService
{
    /**
     * @var $bookmark
     */
    public $bookmark;

    /**
     * BookmarkService constructor.
     * @param Bookmark $bookmark
     */
    public function __construct(Bookmark $bookmark)
    {
        $this->bookmark = $bookmark;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createBookMark(array $data)
    {
        return $this->bookmark->updateOrCreate($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function removeBookMark(array $data)
    {
        return $this->bookmark->where($data)->delete();
    }

    public function fetchMyBookMarks($param)
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $categories = $this->bookmark->select($selectColumn)
            ->when(isset($param['id']), function ($q) use ($param) {
                return $q->where('id', $param['id']);
            })
            ->when(isset($param['user_id']), function ($q) use ($param) {
                return $q->where('user_id', 'LIKE', $param['user_id']);
            })
            ->when(isset($param['store_id']), function ($q) use ($param) {
                return $q->where('store_id', $param['store_id']);
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

    /**
     * @param $data
     * @return mixed
     */
    public function checkBookmarked($data)
    {
        return $this->bookmark->where($data)->exists();
    }
}
