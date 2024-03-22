<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActualPro extends Model
{

  protected $guarded = ['id'];

  protected $table = 'actual_probability';
}
