<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-06
 * Time: 10:36
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $table  = 'tawards';

    protected $fillable = ['sacco_name', 'sacco_route', 'client_name', 's_email', 'msisdn', 'created_at'];

    public $timestamps = false;
}