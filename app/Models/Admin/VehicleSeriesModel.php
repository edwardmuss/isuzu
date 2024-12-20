<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class VehicleSeriesModel extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'series',
        'previous_name',
        'new_model_name_backend',
        'new_model_name_customer',
        'description',
        'price',
        'discount',
        'amount',
        'photo',
        'brochure',
        'status',
    ];

    //sortable columns
    protected $sortable = [
        'id',
        'series',
        'previous_name',
        'new_model_name_backend',
        'new_model_name_customer',
        'description',
        'price',
        'discount',
        'amount',
        'photo',
        'status',
    ];
}
