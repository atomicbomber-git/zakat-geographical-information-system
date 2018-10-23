@extends('shared.layout')
@section('title', 'Kelola Akun Pengumpul')
@section('content')
<div class="container mt-5">
    <h1>
        <i class="fa fa-users"></i>
        Kelola Akun Pengumpul
    </h1>

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-users"></i>
            Kelola Akun Pengumpul
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Nama Administrator </th>
                        <th> Nama Pengguna </th>
                        <th> Tempat Pengumpul Zakat </th>
                        <th> NPWZ </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collectors as $collector)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $collector->user->name }} </td>
                        <td> {{ $collector->user->username }} </td>
                        <td> {{ $collector->name }} </td>
                        <td> {{ $collector->npwz }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection