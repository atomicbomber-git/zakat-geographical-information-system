<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMINISTRATOR_TYPE = 'ADMINISTRATOR';
    const COLLECTOR_TYPE = 'COLLECTOR';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function username()
    {
        return 'username';
    }

    public function collector()
    {
        return $this->hasOne(Collector::class);
    }

    public function getDescriptionAttribute()
    {
        switch ($this->type) {
            case self::ADMINISTRATOR_TYPE:
                return "Administrator Situs";
            case self::COLLECTOR_TYPE:
                return "Administrator UPZ " . $this->collector->name;
        }
    }
}
