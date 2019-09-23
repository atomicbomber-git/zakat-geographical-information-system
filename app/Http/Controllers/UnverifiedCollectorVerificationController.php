<?php

namespace App\Http\Controllers;

use App\Collector;

class UnverifiedCollectorVerificationController extends Controller
{
    public function update(Collector $any_collector)
    {
        $any_collector->update([
            "is_verified" => 1,
        ]);

        return redirect()
            ->route("collector.index")
            ->with('message.success', __('messages.update.success'));
    }
}
