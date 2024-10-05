<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class UssdUser extends Model
{
    use Sortable;

    //Table to map this model
    public $table = 'tussdusers';

    //mass assignable columns
    protected $fillable = ['msisdn', 'session_id', 'ussd_menu', 'ussd_string', 'created_at', 'comment'];

    //sortable columns
    protected $sortable = ['ID','msisdn', 'session_id', 'ussd_menu', 'ussd_string', 'created_at'];
}
