<?php

namespace App\Models;

class Language extends BaseModel
{
    protected $fillable = ['id', 'name'];

    public $timestamps = false;
}
