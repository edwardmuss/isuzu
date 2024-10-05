<?php
/**
 * Created by PhpStorm.
 * User: elm
 * Date: 2019-09-04
 * Time: 11:25
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Conf extends Model
{
    protected $table = 'conf';

    protected $fillable = ['key', 'value'];

    public $timestamps = false;

    public function getFValueAttribute(){
        return number_format($this->value, 2, '.', ',');
    }

    protected $appends = ['f_value'];
}