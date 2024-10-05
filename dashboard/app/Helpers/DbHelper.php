<?php
namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

/**
 * Created by PhpStorm.
 * User: Beth
 * Date: 19-Apr-18
 * Time: 11:22 AM
 */
class DbHelper
{
    /**
     * @param Model $model
     * @param $data
     * @return model
     */
    public static function create_query($model, $data)
    {
        $query = $model->query();

        if (isset($data['daterange'])) {
            $date_range[] = explode(" ", $data['daterange']);
            $start_date[] = explode("-", $date_range[0][0]);
            $start = Carbon::create($start_date[0][0], $start_date[0][1], $start_date[0][2]);

            $end_date[] = explode("-", $date_range[0][2]);
            $end = Carbon::create($end_date[0][0], $end_date[0][1], $end_date[0][2]);

            $query = $query->whereRaw('date(created_at) >= ?', [$start->startOfDay()]);
            $query = $query->whereRaw('date(created_at) <= ?', [$end->endOfDay()]);
        }

        foreach ($data as $item => $value) {
            if (Schema::hasColumn($model->getTable(), $item))
                $query = $query->where($item, 'like', '%' . $value . '%');
        }

        return $query;
    }

    public static function decode_status($status){
        switch ($status){
            case 1:
                return 'Open';
                break;
            case 2:
                return 'On Going';
                break;
            case 3:
                return 'Closed';
                break;
            default:
                return 'Status';
        }
    }
}