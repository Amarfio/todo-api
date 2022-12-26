<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codesc extends Model
{
    use HasFactory;


    //table name
    protected $table = "codescs";

    protected $fillable = ['code_type_id', 'code', 'description','isActive'];
}
