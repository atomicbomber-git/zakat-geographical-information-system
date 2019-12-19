@extends('shared.print-layout')

@section('title', 'Print DATA MUSTAHIK DAN MUZAKI')

@section('extra-style')
    <style>
        @page { size: A4 landscape }
    </style>
@endsection

@section('content')
    <body class="A4 landscape">
        @foreach ($donations->chunk($row_per_page) as $donations)
            <section class="sheet padding-10mm">
                @if($loop->first)
                    <h1 style="text-align: center">
                        DATA MUSTAHIK DAN MUZAKI PONTIANAK <br>
                    </h1>
                @endif

                <table>
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Nama </th>
                            <th> Alamat </th>
                            <th style="text-align:right"> Jumlah (Rp.) </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donations as $donation)
                            <tr>
                                <td> {{ $loop->iteration }}. </td>
                                <td> {{ $donation->mustahiq->name }} </td>
                                <td>
                                    {{ $donation->mustahiq->address }} <br>
                                    Kecamatan {{ $donation->mustahiq->kecamatan }} <br>
                                    Kelurahan {{ $donation->mustahiq->kelurahan }}
                                </td>
                                <td style="text-align:right"> {{ \App\Helper\Formatter::currency($donation->amount) }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                        @if ($loop->last)
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right; font-weight: bold"> Total: </td>
                                    <td style="text-align: right"> {{ \App\Helper\Formatter::currency($donation->sum("amount")) }} </td>
                                </tr>
                            </tfoot>
                        @endif
                </table>
            </section>
        @endforeach
    </body>
@endsection
