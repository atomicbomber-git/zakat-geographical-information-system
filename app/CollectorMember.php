<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectorMember extends Model
{
    public $table = "upz_members";

    public $fillable = [
        "collector_id",
        "name",
        "position",
    ];

    const POSITIONS = [
        "penasehat" => "Penasehat",
        "ketua" => "Ketua",
        "sekretaris" => "Sekretaris",
        "bendahara" => "Bendahara",
        "anggota_1" => "Anggota",
        "anggota_2" => "Anggota",
    ];
}
