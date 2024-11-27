<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PsvAward extends Model
{
    use Sortable;

    //Table to map this model
    public $table = 'tawards';

    //mass assignable columns
    protected $fillable = ['sacco_name', 'sacco_route', 'client_name', 's_email', 'msisdn', 'created_at', 'comment'];

    //sortable columns
    protected $sortable = ['id', 'sacco_name', 'sacco_route', 'client_name', 's_email', 'msisdn', 'created_at'];
}
