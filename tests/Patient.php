<?php

namespace tests;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['birth_year'];
}
