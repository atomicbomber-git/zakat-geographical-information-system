@extends('shared.layout')
@section('title', 'Penerimaan Zakat')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-arrow-down'></i>
        Penerimaan Zakat
    </h1>

    @include('shared.alert.success')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Zakat </li>
            <li class="breadcrumb-item">
                <a href="{{ route('collector.receivement.index', $muzakki->collector) }}">
                    Penerimaan Zakat
                </a>
            </li>
            <li class="breadcrumb-item active">
                {{ $muzakki->name }} ({{ $muzakki->NIK }})
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-arrow-down"></i>
            Penerimaan Zakat
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-bordered'>
                   <thead class="thead thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Tanggal Transaksi </th>
                            <th class="text-right"> Zakat Mal (Rp.) </th>
                            <th class="text-right"> Zakat Fitrah (Rp.) </th>
                            <th class="text-right"> Zakat Fitrah Beras (Kg.) </th>
                            <th class="text-right"> Infak (Rp.) </th>
                            <th class="text-right"> Sedekah (Rp.) </th>
                            <th class="text-right"> Total (Rp.) </th>
                            <th class="text-center"> Aksi </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($muzakki->receivements as $receivement)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $receivement->transaction_date->format('d-m-Y') }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::currency($receivement->zakat) }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::currency($receivement->fitrah) }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::number($receivement->fitrah_beras) }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::currency($receivement->infak) }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::currency($receivement->sedekah) }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::currency($receivement->total) }} </td>
                            <th class="text-center">
                                <a href="{{ route('collector.receivement.edit', $receivement) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <form class="form-delete d-inline-block" action='{{ route('collector.receivement.delete', $receivement) }}' method='POST'>
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
                            <td class="text-right"> {{ \App\Helper\Formatter::number($muzakki->receivements->sum('zakat')) }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::number($muzakki->receivements->sum('fitrah')) }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::number($muzakki->receivements->sum('fitrah_beras')) }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::number($muzakki->receivements->sum('infak')) }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::number($muzakki->receivements->sum('sedekah')) }} </td>
                            <td class="text-right"> {{ \App\Helper\Formatter::number($muzakki->receivements->sum('total')) }} </td>
                            <td></td>
                        </tr>
                   </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
