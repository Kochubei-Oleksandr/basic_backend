<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use App\Traits\JWTSubjectTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use JWTSubjectTrait;
    use BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'usage_policy', 'language_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function __construct(array $attributes = [])
    {
        $this->initBaseModel();
        parent::__construct($attributes);
    }

    protected static function boot() {
        parent::boot();
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getPersonalData($request)
    {
        return $this->getCollections($request, Auth::id())->first();
    }

    public function updatePersonalData($request)
    {
        return $this->updateOne($request, Auth::id(), 'id');
    }
}
