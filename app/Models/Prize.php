<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Prize extends Model
{

    protected $guarded = ['id'];


    public  static function nextPrize($pro, $num_price)
    {
        $PWin = $num_price / ($pro + $num_price);
        return number_format($PWin + $pro,2);
    }
}
