<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code_type extends Model
{
    use HasFactory;

    protected $table = "code_types";
    protected $fillable = ['code','description','isActive'];
}
