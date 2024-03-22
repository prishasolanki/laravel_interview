<?php

use App\Models\Prize;

function currentPrice()
{
  return floatval(Prize::sum('probability'));
}

function remainPrice()
{
  return floatval(100 - Prize::sum('probability'));
}