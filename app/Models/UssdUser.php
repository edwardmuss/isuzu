<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-10-03
 * Time: 12:51
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UssdUser extends Model
{
    protected $table = 'tussdusers';

    public $timestamps = false;

    protected $fillable = ['msisdn', 'session_id', 'ussd_menu', 'ussd_string', 'created_at'];
}