@php
    use Illuminate\Support\Facades\DB;
    use App\Helper\Formatter;
@endphp

@extends('shared.layout')
@section('title', 'Kelola Unit Pengumpul Zakat')
@section('content')
<div class="container mt-5">
    <h1 class="mb-5">
        <i class="fa fa-building"></i>
        Unit Pengumpul Zakat
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.short_name') }} </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.index') }}">
                    Unit Pengumpul Zakat
                </a>
            </li>
            <li class="breadcrumb-item active">
                Detail Unit Pengumpul Zakat
            </li>
        </ol>
    </nav>

    <div class="card mt-5 width-xxl">
        <div class="card-header">
            <i class="fa fa-building"></i>
            Detail Unit Pengumpul Zakat
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img
                        height="480px"
                        width="100%"
                        src="{{ route('collector.thumbnail', $collector) }}" alt="Gambar {{ $collector->name }}">

                </div>
                <div class="col-md-6">
                    <dl>
                        <dt> Nama UPZ </dt>
                        <dd> {{ $collector->name }} </dd>

                        <dt> Nomor Registrasi </dt>
                        <dd> {{ $collector->reg_number }} </dd>

                        <dt> Alamat </dt>
                        <dd> {{ $collector->address }} </dd>

                        <dt> Kecamatan </dt>
                        <dd> {{ $collector->kecamatan }} </dd>

                        <dt> Kelurahan </dt>
                        <dd> {{ $collector->kelurahan }} </dd>

                        <dt> Jumlah Muzakki </dt>
                        <dd> {{ $collector->muzakkis->count() }} </dd>

                        <dt> Jumlah Mustahiq </dt>
                        <dd> {{ $collector->mustahiqs->count() }} </dd>

                        @foreach (\App\CollectorMember::POSITIONS as $key => $value)
                        <dt> {{ $value }} </dt>
                        <dd> {{ $collector->members[$key] ?? '-' }} </dd>
                        @endforeach

                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            Daftar Mustahiq
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead class="thead thead-dark">
                        <tr>
                            <th> Nama </th>
                            <th> NIK </th>
                            <th> Usia </th>
                            <th> Alamat </th>
                            <th> Telepon </th>
                            <th> J. Kelamin </th>
                            <th> Pekerjaan </th>
                            <th> Asnaf </th>
                            <th> Program Bantuan </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collector->mustahiqs as $mustahiq)
                        <tr>
                            <td> {{ $mustahiq->name }} </td>
                            <td> {{ $mustahiq->nik }} </td>
                            <td> {{ $mustahiq->age }} </td>
                            <td> {{ $mustahiq->address }} </td>
                            <td> {{ $mustahiq->phone }} </td>
                            <td> {{ Formatter::gender($mustahiq->gender) }} </td>
                            <td> {{ $mustahiq->occupation }} </td>
                            <td> {{ $mustahiq->asnaf }} </td>
                            <td> {{ $mustahiq->help_program }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            Daftar Muzakki
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-bordered table-striped'>
                   <thead class="thead thead-dark">
                        <tr>
                            <th> Nama </th>
                            <th> NIK </th>
                            <th> Alamat </th>
                            <th> Telepon </th>
                            <th> J. Kelamin </th>
                            <th> Nomor Registrasi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($collector->muzakkis as $muzakki)
                        <tr>
                            <td> {{ $muzakki->name }} </td>
                            <td> {{ $muzakki->NIK }} </td>
                            <td> {{ $muzakki->address }} </td>
                            <td> {{ $muzakki->phone }} </td>
                            <td> {{ Formatter::gender($muzakki->gender) }} </td>
                            <td> {{ $muzakki->reg_number }} </td>
                        </tr>
                       @endforeach
                   </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
    @include("shared.datatables")
@endsection
