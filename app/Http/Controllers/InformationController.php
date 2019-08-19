<?php

namespace App\Http\Controllers;

use App\Information;

class InformationController extends Controller
{
    public function edit(Information $information)
    {
        $this->authorize('update', $information);
        return view("information.edit", compact("information"));
    }

    public function update(Information $information)
    {
        $this->authorize('update', $information);

        $data = $this->validate(request(), [
            "description" => ["required", "string", "max:50000"],
        ]);

        $information->update($data);
        return redirect()
            ->route("information.edit", $information)
            ->with('message.success', __('messages.update.success'));
    }
}
