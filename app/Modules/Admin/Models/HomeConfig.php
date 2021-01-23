<?php


namespace App\Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = "cb_admin";
    protected $primaryKey = "ID";
    public $timestamps = false;
    public static $snakeAttributes = false;
}