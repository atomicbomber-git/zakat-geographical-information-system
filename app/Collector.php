<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Support\Facades\DB;

class Collector extends Model implements HasMedia
{
    use HasMediaTrait;

    public $table = "upz";

    public $fillable = [
        "name",
        "address",
        "latitude",
        "longitude",
        "user_id",
        "reg_number",
        "kecamatan",
        "kelurahan",
        "phone",
        "is_verified",
    ];

    const HAS_RELATIONS = ["receivements", "donations", "muzakkis", "mustahiqs", "reports"];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('verified', function (Builder $builder) {
            $builder->where('is_verified', 1);
        });
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumbnail')
            ->width(640)
            ->height(480)
            ->sharpen(10);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receivements()
    {
        return $this->hasMany(Receivement::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function muzakkis()
    {
        return $this->hasMany(Muzakki::class);
    }

    public function mustahiqs()
    {
        return $this->hasMany(Mustahiq::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function members()
    {
        return $this->hasMany(CollectorMember::class);
    }

    public function report_total_amount()
    {
        return $this->hasOne(Report::class)
            ->addSelect("collector_id", DB::raw("SUM(zakat + fitrah + infak) AS value"))
            ->groupBy("collector_id");
    }

    public function scopeUnverified($query)
    {
        $query->where("is_verified", 0);
    }
}
