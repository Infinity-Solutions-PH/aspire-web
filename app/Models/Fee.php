<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'amount', 'track', 'strand', 'specialization'])]
class Fee extends Model
{
    //
}
