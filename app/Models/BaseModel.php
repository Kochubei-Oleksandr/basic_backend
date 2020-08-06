<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use BaseModelTrait;

    public function __construct()
    {
        $this->initBaseModel();
        parent::__construct();
    }
}
