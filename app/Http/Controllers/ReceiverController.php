<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receiver;
use Illuminate\Validation\Rule;

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
        $receivers = Receiver::select('id', 'name', 'latitude', 'longitude')
            ->get();

        return view('receiver.create', compact('receivers'));
    }
    
    public function store()
    {
        $data = $this->validate(request(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required',
            'nik' => 'required|unique:receivers',
            'address' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'phone' => 'required',
            'sex' => ['required', Rule::in('L', 'P')],
            'occupation' => 'required',
            'ansaf' => 'required',
            'help_program' => 'required',
            'amount' => 'required|gt:0',
        ]);
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