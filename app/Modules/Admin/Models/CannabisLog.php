<?php


namespace App\Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;

class CannabisLog extends Model
{
    protected $table = "cannabis_logs";
    
    protected $fillable = [
        'id',
        'code',
        'message',
    ];
}