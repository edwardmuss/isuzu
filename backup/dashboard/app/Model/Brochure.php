<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Brochure extends Model
{
    use Sortable;

    //Table to map this model
    public $table = 'tbrochurereq';

    //mass assignable columns
    protected $fillable = ['client_name', 'msisdn', 'client_email', 'brochure_type', 'created_at', 'comment'];

    //sortable columns
    protected $sortable = ['id', 'client_name', 'msisdn', 'client_email', 'brochure_type', 'created_at'];

    public function getBrochureAttribute()
    {
        if (strpos($this->brochure_type, 'Request for a Brochure -') !== false) {
            return str_replace('Request for a Brochure -', '', $this->brochure_type);
        } else if (strpos($this->brochure_type, 'Request for a ') !== false) {
            return str_replace('Request for a ', '', $this->brochure_type);
        } else {
            return $this->brochure_type;
        }
    }

    protected $appends = ['brochure'];
}
