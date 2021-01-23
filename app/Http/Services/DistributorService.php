<?php


namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\Distributor;
use App\Models\DistributorLocation;
use App\Models\DistributorReset;
use App\Models\UserReset;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DistributorService
{
    /**
     * @var User
     */
    public $distributor;

    /**
     * DistributorService constructor.
     * @param Distributor $distributor
     */
    public function __construct(Distributor $distributor)
    {
        $this->distributor = $distributor;
    }

    /**
     * @param $distributor
     * @return mixed
     */
    public function generateAccessToken($distributor)
    {
        $distributor->accessToken = $distributor->createToken(trans('Cannabies.AppName'))->accessToken;
        return $distributor;
    }

    public function getDistributors($param)
    {
        if (isset($param['columns']) && !empty($param['columns'])) {
            $selectColumn = $param['columns'];
        } else {
            $selectColumn = "*";
        }

        $distributors = $this->distributor->with(['proofs', 'orders'])->select($selectColumn)
            ->when(isset($param['id']), function ($q) use ($param) {
                return $q->where('id', $param['id']);
            })
            ->when(isset($param['order_status']), function ($q) use ($param) {
                $q->whereHas('orders', function ($query) use ($param) {
                    $query->where('order_status', $param['order_status']);
                });
            })->when(isset($param['in_order_status']), function ($q) use ($param) {
                $q->whereHas('orders', function ($query) use ($param) {
                    $query->whereIn('order_status', $param['in_order_status']);
                });
            })->when(isset($param['order_uid']), function ($q) use ($param) {
                $q->whereHas('orders', function ($query) use ($param) {
                    $query->where('order_uid', $param['order_uid']);
                });
            })->when(isset($param['order_delivery_schedule_date']), function ($q) use ($param) {
                $q->whereHas('orders', function ($query) use ($param) {
                    $query->where('distributor_order.schedule_date', $param['order_delivery_schedule_date']);
                });
            })
            ->when(isset($param['name']), function ($q) use ($param) {
                return $q->where('name', 'LIKE', $param['name']);
            })
            ->
            when(isset($param['status']), function ($q) use ($param) {
                return $q->where('status', $param['status']);
            })
            ->when((isset($param['country_code']) && isset($param['phone_number'])), function ($q) use ($param) {
                return $q->where(['country_code' => $param['country_code'], 'phone_number' => $param['phone_number']]);
            });

        if (isset($param['pagesize']) && !empty($param['pagesize'])) {
            if (isset($param['api'])) {
                $distributors = CommonHelper::restPagination($distributors->paginate($param['pagesize']));
            } else {
                $distributors = $distributors->paginate($param['pagesize']);
            }
        } elseif (!isset($param['pagesize']) && empty($param['pagesize'])) {
            $distributors = $distributors->get();
        }

        return $distributors;

    }

    /**
     * @param $distributorId
     * @return mixed
     */
    public function generateDistributorResetToken($distributorId)
    {

        DistributorReset::where('distributor_id', $distributorId)->delete();
        return DistributorReset::create([
            'distributor_id' => $distributorId,
            'reset_token'    => Str::uuid(),
        ]);
    }

    /**
     * @param $distributorId
     * @param $resetToken
     * @param $password
     * @return bool
     */
    public function resetPassword($distributorId, $resetToken, $password)
    {
        $distributorReset = DistributorReset::where(['distributor_id' => $distributorId, 'reset_token' => $resetToken])->first();
        if ($distributorReset) {
            $distributorReset->delete();
            $distributor           = $this->distributor->find($distributorId);
            $distributor->password = Hash::make($password);
            $distributor->save();
            return true;
        }

        return false;
    }

    /**
     * update driver profile
     * @param $distributorId
     * @param array $data
     * @return mixed
     */
    public function updateDistributor($distributorId, array $data)
    {
        $distributor = $this->distributor->find($distributorId);
        $data        = Arr::only($data, ['name', 'gender', 'profile_image']);
        return $distributor->update($data);
    }

    /**
     * update distribuor location
     * @param array $data
     * @return mixed
     */
    public function updateDistributorLocation(array $data)
    {
        $distributor = $this->distributor->find($data['id']);
        return $distributor->locations()->save(new DistributorLocation(['longitude' => $data['longitude'], 'latitude' => $data['latitude']]));
    }

    /**
     * update distributor status
     * @param string $status
     * @return mixed
     */
    public function updateDistributorStatus(string $status, $id = null)
    {
        if ($id) {
            $distributor = $this->distributor->find($id);
        } else {
            $distributor = request()->user();
        }
        $distributor->current_status  = $status;
        $distributor->last_login_time = now();
        return $distributor->save();
    }

    public function driverLastOrderData($distributorId)
    {
        $param  = [
            'id' => $distributorId,
            'in_order_status' => ['on_delivery', 'amount_received', 'delivered'],
        ];
        $order = $this->getDistributors($param)->first();
        return $order;
    }


}
