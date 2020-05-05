<?php

namespace Acolyte\ErrorLog\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $table = 'error_log';

    public $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id','method_name','line_number','file_path','exception_message','object','type','screenshot','page_url','arguments','prefix','domain'
    ];
}
