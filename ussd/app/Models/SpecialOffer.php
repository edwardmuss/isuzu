<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-06
 * Time: 10:40
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected $table = 'tspecialoffers';

    protected $fillable = ['offer_id', 'offer_name', 'client_name', 'msisdn', 'client_email', 'created_at'];

    public $timestamps = false;
}