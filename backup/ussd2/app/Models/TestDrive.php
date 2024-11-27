<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-05
 * Time: 12:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TestDrive extends Model
{
    protected $table = 'ttestdrivereq';

    public $timestamps = false;

    protected $fillable = ['client_name', 'client_email', 'msisdn', 'request', 'location', 'created_at', 'comment', 'isSent'];
}