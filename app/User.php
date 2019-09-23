<?php

namespace App;

use App\Enums\UserType;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('verified', function (Builder $builder) {
            $builder
                ->where(function ($query) {
                    $query
                        ->whereHas("collector")
                        ->where('type', UserType::COLLECTOR);
                })
                ->orWhere('type', '<>', UserType::COLLECTOR);
        });
    }

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
