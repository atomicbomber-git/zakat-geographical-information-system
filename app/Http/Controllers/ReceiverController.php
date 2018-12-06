<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receiver;

class ReceiverController extends Controller
{
    public function index()
    {
        $receivers = Receiver::select(
            "name", "nik", "address", "kecamatan", "kelurahan",
            "phone", "sex", "occupation", "ansaf", "help_program",
            "amount"
        )
        ->get();

        return view('receiver.index', compact('receivers'));
    }
    
    public function create()
    {
    }
    
    public function store()
    {   
    }
    
    public function edit(Receiver $receiver)
    {
    }
    
    public function update(Receiver $receiver)
    {
    }
    
    public function delete(Receiver $receiver) {
        $receiver->delete();

        return redirect()->back()
            ->with('message.success', __('messages.delete.success'));
    }
}
