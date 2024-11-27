<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class VehicleSale extends Model
{
    use Sortable;

    //Table to map this model
    public $table = 'trequestquote';

    public $timestamps = false;
    //mass assignable columns
    protected $fillable = ['client_name', 'client_msisdn', 'quote_name', 'quote_number', 'amount', 'email_ad', 'created_at', 'comment', 'dealer'];

    //sortable columns
    protected $sortable = ['ID', 'client_name', 'client_msisdn', 'quote_name', 'quote_number', 'amount', 'email_ad', 'created_at', 'comment'];
}
