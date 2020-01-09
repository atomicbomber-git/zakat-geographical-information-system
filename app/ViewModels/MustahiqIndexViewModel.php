<?php

namespace App\ViewModels;

use App\Collector;
use App\Mustahiq;
use Illuminate\Database\Eloquent\Builder;
use Spatie\ViewModels\ViewModel;

class MustahiqIndexViewModel extends ViewModel
{
    public $collector;

    public function __construct(Collector $collector)
    {
        $this->collector = $collector;
    }

    public function mustahiqs()
    {
        return $mustahiqs = Mustahiq::query()
            ->select(
                "id",
                "name",
                "nik",
                "address",
                "kecamatan",
                "kelurahan",
                "phone",
                "gender",
                "occupation",
                "asnaf",
                "nomor_kk",
                "collector_id",
                "age",
                "description",
                "created_at",
                "updated_at",
                "program_bantuan",
            )
            ->whereHas("collector", function (Builder $query) {
                $query->where("id", $this->collector->id);
            })
            ->withCount("donations")
            ->orderByDesc("updated_at")
            ->orderByDesc("created_at")
            ->get();
    }
}
