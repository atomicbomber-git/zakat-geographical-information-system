<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Information;

class InformationController extends Controller
{
    public function edit(Information $information)
    {
        return view("information.edit", compact("information"));
    }

    public function update(Information $information)
    {
        $data = $this->validate(request(), [
            "description" => ["required", "string", "max:50000"],
        ]);

        return redirect()
            ->route("information.edit", $information)
            ->with('message.success', __('messages.update.success'));
    }

    public function show(Information $information)
    {
        ;
    }
}
