<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Collector extends Model implements HasMedia
{
    use HasMediaTrait;

    public $fillable = [
        'name', 'address', 'latitude', 'longitude', 'user_id', 'npwz', "kecamatan", "kelurahan"
    ];

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

    // public function reports()
    // {
    //     return $this->hasMany(Report::class);
    // }
}
