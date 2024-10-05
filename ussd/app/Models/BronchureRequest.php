<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-06
 * Time: 12:00
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BronchureRequest extends Model
{
    protected $table = 'tbrochurereq';

    protected $fillable = ['msisdn', 'client_name', 'client_email', 'brochure_type', 'created_at'];

    public $timestamps = false;
}