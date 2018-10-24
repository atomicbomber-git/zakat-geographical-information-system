@extends('shared.layout')
@section('title', 'Kelola Unit Pengumpulan Zakat')
@section('content')
<div class="container mt-5">
    <h1>
        <i class="fa fa-building"></i>
        Kelola Unit Pengumpulan Zakat
    </h1>

    <div class="row">
        <div class="col text-left"></div>
        <div class="col-2"></div>
        <div class="col text-right">
            <a href="{{ route('collector.create') }}" class="btn btn-dark btn-sm">
                Tambah Unit Pengumpulan Zakat
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    
    @include('shared.message', ['session_key' => 'message.success', 'state' => 'success'])

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-building"></i>
            Kelola Unit Pengumpulan Zakat
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
                        <th> Aksi </th>
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
                        <td>
                            <a href="{{ route('collector.edit', $collector) }}" class="btn btn-dark btn-sm">
                                Sunting Data
                                <i class="fa fa-pencil"></i>
                            </a>

                            <form action="{{ route('collector.delete', $collector) }}" method="POST" class="d-inline-block">
                                @csrf
                                <button {{ $collector->reports_count > 0 ? 'disabled' : '' }} class="btn btn-danger btn-sm">
                                    Hapus
                                    <i class="fa fa-trash"></i>
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