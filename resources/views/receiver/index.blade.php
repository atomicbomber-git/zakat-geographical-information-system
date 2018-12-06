@extends('shared.layout')
@section('title', 'Daftar Penerima Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-users'></i>
        Daftar Penerima Zakat
    </h1>

    <div class="row mb-2">
        <div class="col text-left"></div>
        <div class="col-2"></div>
        <div class="col text-right">
            <a href="{{ route('receiver.create') }}" class="btn btn-dark btn-sm">
                Tambah Penerima Zakat
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>

    @include('shared.message', ['session_key' => 'message.success', 'state' => 'success'])

    <div class="card">
        <div class="card-header">
            <i class="fa fa-users"></i>
            Daftar Penerima Zakat
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-bordered'>
                   <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Nama </th>
                            <th> NIK </th>
                            <th> Alamat </th>
                            <th> Kecamatan </th>
                            <th> Kelurahan </th>
                            <th> No. HP </th>
                            <th> Jenis Kelamin </th>
                            <th> Pekerjaan </th>
                            <th> Ansaf </th>
                            <th> Program Bantuan </th>
                            <th> Jumlah Zakat (Rp.) </th>
                            <th> Aksi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($receivers as $receiver)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $receiver->name }} </td>
                            <td> {{ $receiver->nik }} </td>
                            <td> {{ $receiver->address }} </td>
                            <td> {{ $receiver->kecamatan }} </td>
                            <td> {{ $receiver->kelurahan }} </td>
                            <td> {{ $receiver->phone }} </td>
                            <td> {{ $receiver->sex }} </td>
                            <td> {{ $receiver->occupation }} </td>
                            <td> {{ $receiver->ansaf }} </td>
                            <td> {{ $receiver->help_program }} </td>
                            <td> {{ number_format($receiver->amount) }} </td>
                            <td>
                                <form action='{{ route('receiver.delete') }}' method='POST' class='d-inline-block'>
                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        <i class='fa fa-trash'></i>
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
</div>
@endsection