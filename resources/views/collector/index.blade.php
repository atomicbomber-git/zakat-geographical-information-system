@php
    use Illuminate\Support\Facades\DB;
@endphp

@extends('shared.layout')
@section('title', 'Kelola Unit Pengumpulan Zakat')
@section('content')
<div class="container mt-5">
    <h1 class="mb-5">
        <i class="fa fa-building"></i>
        Unit Pengumpulan Zakat
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.short_name') }} </li>
            <li class="breadcrumb-item active"> Unit Pengumpulan Zakat </li>
        </ol>
    </nav>

    @include('shared.message', ['session_key' => 'message.success', 'state' => 'success'])

    <div class="card mt-5">
        <div class="card-header">
            <i class="fa fa-building"></i>
            Unit Pengumpulan Zakat
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Nama Administrator </th>
                        <th> Nama Pengguna </th>
                        <th> Tempat Pengumpulan Zakat </th>
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
                            <a href="{{ route('collector.show', $collector) }}" class="btn btn-dark btn-sm">
                                <i class="fa fa-list"></i>
                            </a>

                            <a href="{{ route('collector.edit', $collector) }}" class="btn btn-dark btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <form
                                class="form-delete d-inline-block"
                                action="{{ route('collector.delete', $collector) }}"
                                method="POST">
                                @csrf
                                <button {{ Auth::user()->can("delete", $collector) ? '' : 'disabled' }} class="btn btn-danger btn-sm">
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

@section("script")
    @include("shared.datatables")
@endsection