@extends('shared.layout')
@section('title', 'Mustahik')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-user'></i>
        Mustahik
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item"> UPZ {{ $collector->name }} </li>
            <li class="breadcrumb-item active"> Mustahik </li>
        </ol>
    </nav>

    <div class="my-3 text-right">
        <a href="{{ route("collector.mustahiq.create", $collector) }}" class="btn btn-sm btn-dark">
            Tambah Mustahik
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-user"></i>
            Mustahik
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                @include("shared.mustahiq.index-table", [
                    "mustahiqs" => $mustahiqs
                ])
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @include('shared.datatables')
@endsection
