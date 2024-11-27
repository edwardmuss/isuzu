<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class LocateDealer extends Model
{
    use Sortable;

    //Table to map this model
    public $table = 'tcontactreq';

    //mass assignable columns
    protected $fillable = ['contact_id', 'client_name', 'msisdn', 'client_email', 'location', 'created_at', 'comment', 'status', 'responsible'];

    //sortable columns
    protected $sortable = ['id', 'contact_id', 'client_name', 'msisdn', 'client_email', 'location', 'created_at'];
}
