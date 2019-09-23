@php
    use Illuminate\Support\Facades\DB;
@endphp

@extends('shared.layout')
@section('title', 'Verifikasi Unit Pengumpulan Zakat')
@section('content')
<div class="container mt-5">
    <h1 class="mb-5">
        <i class="fa fa-users"></i>
        Verifikasi Unit Pengumpulan Zakat
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.short_name') }} </li>
            <li class="breadcrumb-item active"> Verifikasi UPZ </li>
        </ol>
    </nav>

    @include('shared.message', ['session_key' => 'message.success', 'state' => 'success'])

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-users"></i>
            Verifikasi Unit Pengumpulan Zakat
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Nama Administrator </th>
                        <th> Nama Pengguna </th>
                        <th> Nama UPZ </th>
                        <th> Nomor Registrasi </th>
                        <th> Alamat </th>
                        <th> Nomor Telefon </th>
                        <th class="text-center"> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collectors as $collector)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $collector->user->name }} </td>
                        <td> {{ $collector->user->username }} </td>
                        <td> {{ $collector->name }} </td>
                        <td> {{ $collector->reg_number }} </td>
                        <td> {{ $collector->address }} </td>
                        <td style="width: 10rem"> {{ $collector->phone }} </td>
                        <td class="text-center" style="width: 10rem">
                            <form
                                method="POST"
                                action="{{ route("unverified-collector-verification.update", $collector) }}">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    Verifikasi
                                    <i class="fa fa-check"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section("script")
    @include("shared.datatables")
@endsection
