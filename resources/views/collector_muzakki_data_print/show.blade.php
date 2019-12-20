@extends('shared.print-layout')

@section('title', 'Print Data Muzaki')

@section('extra-style')
    <style>
        @page { size: A4 landscape }
    </style>
@endsection

@section('content')
    <body class="A4 landscape">
        @foreach ($muzakkis->chunk($rowPerPage) as $muzakkiChunk)
            <section class="sheet padding-10mm">
                @if($loop->first)
                    <h1 style="text-align: center">
                        DATA MUZAKI KOTA PONTIANAK <br>
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
                        @foreach ($muzakkiChunk as $muzakki)
                            <tr>
                                <td> {{ ($loop->parent->index * $rowPerPage) + $loop->iteration }}. </td>
                                <td> {{ $muzakki->name }} </td>
                                <td>
                                    {{ $muzakki->address }} <br>
                                </td>
                                <td>
                                    {{ $muzakki->receivements_last_transaction_date }}
                                </td>
                                <td style="text-align:right">
                                    {{ \App\Helper\Formatter::currency($muzakki->receivements_amount_sum) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endforeach
    </body>
@endsection
