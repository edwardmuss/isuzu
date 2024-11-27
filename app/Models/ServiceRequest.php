<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-05
 * Time: 13:02
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $table = 'tservicereq';

    public $timestamps = false;

    protected $fillable = ['vehicle_type', 'reg_no', 'client_name', 'msisdn', 'client_email', 'created_at', 'comment', 'status', 'responsible', 'isSent', 'location'];
}