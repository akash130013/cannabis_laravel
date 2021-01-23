<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoggedToken extends Model
{
    /**
     * property which need to guarded against mass assignment
     * table: logged_tokens
     * @var array $guarded
     */
    protected $guarded = [];
}
