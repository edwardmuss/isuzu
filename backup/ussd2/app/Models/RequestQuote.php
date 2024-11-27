<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-05
 * Time: 10:20
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class RequestQuote extends Model
{
    protected $table = 'trequestquote';

    public $timestamps = false;

    protected $fillable = ['client_name', 'client_msisdn', 'quote_name', 'quote_number', 'amount', 'email_ad', 'created_at', 'comment', 'isSent', 'dealer'];

}