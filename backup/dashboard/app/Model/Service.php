<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Service extends Model
{
    use Sortable;

    //Table to map this model
    public $table = 'tservicereq';

    //mass assignable columns
    protected $fillable = ['vehicle_type', 'reg_no', 'client_name', 'msisdn', 'client_email', 'created_at', 'comment', 'status', 'responsible'];

    //sortable columns
    protected $sortable = ['id', 'vehicle_type', 'reg_no', 'client_name', 'msisdn', 'client_email', 'created_at'];
}
