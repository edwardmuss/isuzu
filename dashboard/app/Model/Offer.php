<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Offer extends Model
{
    use Sortable;

    //Table to map this model
    public $table = 'tspecialoffers';

    //mass assignable columns
    protected $fillable = ['offer_id', 'offer_name', 'client_name', 'client_email','msisdn', 'created_at', 'comment', 'responsible', 'status'];

    //sortable columns
    protected $sortable = ['id', 'offer_id', 'offer_name', 'client_name', 'client_email','msisdn', 'created_at'];
}
