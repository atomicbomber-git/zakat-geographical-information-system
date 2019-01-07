@extends('shared.layout')
@section('title', 'Tambah Penerima Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Tambah Penerima Zakat
    </h1>

    <div id="app">
        <receiver/>
    </div>

    @javascript('receivers', $receivers)
    @javascript('collectors', $collectors)
</div>
@endsection