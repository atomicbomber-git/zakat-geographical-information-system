@extends('shared.layout')
@section('title', 'Muzakki')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-user'></i>
        Muzakki
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item active"> Muzakki </li>
        </ol>
    </nav>

    <div class="my-3 text-right">
        <a href="{{ route("collector.muzakki.create") }}" class="btn btn-sm btn-dark">
            Tambah Muzakki
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-user"></i>
            Muzakki
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-bordered table-striped'>
                   <thead class="thead-dark">
                        <tr>
                            <th> Nama </th>
                            <th> NIK </th>
                            <th> Alamat </th>
                            <th> Pekerjaan </th>
                            <th> Telepon </th>
                            <th> J. Kelamin </th>
                            <th> NPWZ </th>
                            <th class="text-center"> Aksi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($muzakkis as $muzakki)
                        <tr>
                            <td> {{ $muzakki->name }} </td>
                            <td> {{ $muzakki->NIK }} </td>
                            <td>
                                {{ $muzakki->address }},
                                {{ $muzakki->kecamatan }}, <br/>
                                {{ $muzakki->kelurahan }}  <br/>
                            </td>
                            <td> {{ $muzakki->occupation }} </td>
                            <td> {{ $muzakki->phone }} </td>
                            <td> {{ App\Muzakki::GENDERS[$muzakki->gender] ?? '-' }} </td>
                            <td> {{ $muzakki->npwz }} </td>
                            <td class="text-center">

                                <a href="{{ route('collector.muzakki.edit', $muzakki) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                @can('delete', $muzakki)
                                <form class="form-delete d-inline-block" action='{{ route('collector.muzakki.delete', $muzakki) }}' method='POST'>
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
