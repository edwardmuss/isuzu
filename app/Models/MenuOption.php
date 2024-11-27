<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuOption extends Model
{
    use HasFactory;

    protected $fillable = ['option_code', 'option_name', 'menu_message', 'parent_id', 'action'];

    public function parent()
    {
        return $this->belongsTo(MenuOption::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuOption::class, 'parent_id');
    }

    public function getHasChildrenAttribute()
    {
        return $this->children()->exists(); // Adjust this if your relation is named differently
    }
}
