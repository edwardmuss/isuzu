<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-05
 * Time: 13:20
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PartsRequest extends Model
{
    protected $table = 'tpartsreq';

    public $timestamps = false;

    protected $fillable = ['vehicle_type', 'parts_desc', 'client_name', 'msisdn', 'client_email', 'location', 'created_at', 'comment', 'status', 'responsible', 'isSent'];
}