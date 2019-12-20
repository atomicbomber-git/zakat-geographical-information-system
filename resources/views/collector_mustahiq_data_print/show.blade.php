@extends('shared.print-layout')

@section('title', 'Print Data Mustahik')

@section('extra-style')
    <style>
        @page { size: A4 landscape }
    </style>
@endsection

@section('content')
    <body class="A4 landscape">
        @foreach ($mustahiqs->chunk($rowPerPage) as $mustahiqChunk)
            <section class="sheet padding-10mm">
                @if($loop->first)
                    <h1 style="text-align: center">
                        DATA MUSTAHIK UPZ {{ $collector->name }} <br>
                    </h1>
                @endif

                <table>
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Nama </th>
                            <th> Alamat </th>
                            <th> Tanggal Transaksi Terakhir </th>
                            <th style="text-align:right"> Jumlah (Rp.) </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mustahiqChunk as $mustahiq)
                            <tr>
                                <td> {{ ($loop->parent->index * $rowPerPage) + $loop->iteration }}. </td>
                                <td> {{ $mustahiq->name }} </td>
                                <td>
                                    {{ $mustahiq->address }} <br>
                                </td>
                                <td>
                                    {{ $mustahiq->donations_last_transaction_date }} <br>
                                </td>
                                <td style="text-align:right">
                                    {{ \App\Helper\Formatter::currency($mustahiq->donations_amount_sum) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endforeach
    </body>
@endsection
