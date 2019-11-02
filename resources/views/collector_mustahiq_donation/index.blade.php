@extends('shared.layout')
@section('title', 'Pendistribusian Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-arrow-down'></i>
        Pendistribusian Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.donation.index') }}">
                    Pendistribusian Zakat
                </a>
            </li>
            <li class="breadcrumb-item active">
                {{ $mustahiq->name }} ({{ $mustahiq->nik }})
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-arrow-down"></i>
            Pendistribusian Zakat
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-bordered'>
                   <thead class="thead thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Tanggal Transaksi </th>
                            <th class="text-right"> Nominal (Rp.) </th>
                            <th class="text-center"> Aksi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($mustahiq->donations as $donation)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $donation->transaction_date->format('d-m-Y') }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::currency($donation->amount) }} </td>
                            <th class="text-center">
                                <a href="{{ route('collector.donation.edit', $donation) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <form class="form-delete d-inline-block" action='{{ route('collector.donation.delete', $donation) }}' method='POST'>
                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                            </th>
                        </tr>
                       @endforeach
                   </tbody>

                   <tfoot>
                        <tr>
                            <td colspan="2" class="text-right"> Total: </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::number($mustahiq->donations->sum('amount')) }} </td>
                            <td></td>
                        </tr>
                   </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- @javascript('donations', $yearly_donations) --}}
@endsection
