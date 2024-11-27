<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class TestDrive extends Model
{
    use Sortable;

    //Table to map this model
    public $table = 'ttestdrivereq';

    //mass assignable columns
    protected $fillable = ['client_name', 'msisdn', 'client_email', 'request', 'created_at', 'comment'];

    //sortable columns
    protected $sortable = ['id', 'client_name', 'msisdn', 'client_email', 'request', 'created_at'];
}
