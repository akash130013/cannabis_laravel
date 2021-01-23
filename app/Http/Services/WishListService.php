<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\WishList;

class WishListService
{
    /**
     * @var $wishlist
     */
    public $wishlist;

    /**
     * WishListService constructor.
     * @param WishList $wishlist
     */
    public function __construct(WishList $wishlist)
    {
        $this->wishlist = $wishlist;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createWishlist(array $data)
    {
        return $this->wishlist->updateOrCreate($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function removeWishlist(array $data)
    {
        return $this->wishlist->where($data)->delete();
    }

    public function fetchMyWishlists($param)
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $wishlist = $this->wishlist->with(['product' => function ($query) {
            $query->with(['getCategory', 'getImage']);
        }])->select($selectColumn)
            ->when(isset($param['id']), function ($q) use ($param) {
                return $q->where('id', $param['id']);
            })
            ->when(isset($param['user_id']), function ($q) use ($param) {
                return $q->where('user_id', $param['user_id']);
            })
            ->when(isset($param['product_id']), function ($q) use ($param) {
                return $q->where('product_id', $param['product_id']);
            });

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $wishlist = CommonHelper::restPagination($wishlist->paginate($param['pagesize']));
            } else {
                $wishlist = $wishlist->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $wishlist = $wishlist->get();
        }

        return $wishlist;
    }

    /**
     * check if product is wishlisted
     * @param $data
     * @return mixed
     */
    public function checkWishList($data)
    {
        return $this->wishlist->where($data)->exists();
    }

}
