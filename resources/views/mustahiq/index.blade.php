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
            <li class="breadcrumb-item active"> Mustahik </li>
        </ol>
    </nav>

    <div class="my-3 text-right">
        <a href="{{ route("collector.mustahiq.create") }}" class="btn btn-sm btn-dark">
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
                <table class='table table-sm table-bordered table-striped'>
                    <thead class="thead-dark">
                        <tr>
                            <th> Nama </th>
                            <th> NIK </th>
                            <th> Nomor KK </th>
                            <th> Usia </th>
                            <th> Alamat </th>
                            <th> Telepon </th>
                            <th> J. Kelamin </th>
                            <th> Pekerjaan </th>
                            <th> Asnaf </th>
                            <th> Deskripsi Kondisi </th>
                            <th> Program Bantuan </th>
                            <th class="text-center"> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mustahiqs as $mustahiq)
                        <tr>
                            <td> {{ $mustahiq->name }} </td>
                            <td> {{ $mustahiq->nik }} </td>
                            <td> {{ $mustahiq->nomor_kk }} </td>
                            <td> {{ $mustahiq->age }} </td>
                            <td>
                                {{ $mustahiq->address }},
                                {{ $mustahiq->kecamatan }}, <br/>
                                {{ $mustahiq->kelurahan }}  <br/>
                            </td>
                            <td> {{ $mustahiq->phone }} </td>
                            <td> {{ \App\Mustahiq::GENDERS[$mustahiq->gender] ?? '-' }} </td>
                            <td> {{ $mustahiq->occupation }} </td>
                            <td> {{ $mustahiq->asnaf }} </td>
                            <td> {{ $mustahiq->description }} </td>
                            <td> {{ $mustahiq->program_bantuan }} </td>
                            <td class="text-center">
                                @can("update", $mustahiq)
                                <a href="{{ route("collector.mustahiq.edit", $mustahiq) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                @endcan

                                @can("delete", $mustahiq)
                                <form class="form-delete d-inline-block" action='{{ route("collector.mustahiq.delete", $mustahiq) }}' method='POST'>
                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                                @endcan
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

@section('script')
    @include('shared.datatables')
@endsection
