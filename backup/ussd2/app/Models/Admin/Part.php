<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Part extends Model
{
    use Sortable;

    //Table to map this model
    public $table = 'tpartsreq';

    //mass assignable columns
    protected $fillable = ['vehicle_type', 'parts_desc', 'client_name', 'msisdn', 'client_email', 'location', 'created_at', 'status', 'responsible'];

    //sortable columns
    protected $sortable = ['id', 'vehicle_type', 'parts_desc', 'client_name', 'msisdn', 'client_email', 'location', 'created_at'];
}
