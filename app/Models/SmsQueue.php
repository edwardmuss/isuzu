<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-04
 * Time: 11:25
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SmsQueue extends Model
{
    protected $table = 'tsmsqueue';

    protected $fillable = ['SourceAdr', 'DestinationAdr', 'Msg', 'status', 'CreatedDate'];

    public $timestamps = false;
}