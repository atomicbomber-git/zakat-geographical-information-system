@extends('shared.print-layout')

@section('title', 'Print Laporan Penerimaan Zakat')

@section('extra-style')
    <style>
        @page { size: A4 landscape }
    </style>
@endsection

@section('content')
    <body class="A4 landscape">
        @foreach ($receivements->chunk($row_per_page) as $receivements)
            <section class="sheet padding-10mm">
                @if($loop->first)
                    <h1 style="text-align: center">
                        LAPORAN PENDISTRIBUSIAN ZAKAT TAHUN {{ $year }} <br>
                        UNIT PENDISTRIBUSIAN ZAKAT {{ $collector->name }}
                    </h1>
                @endif

                <table>
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Nama </th>
                            <th> Alamat </th>
                            <th style="text-align:right"> Zakat (Rp.) </th>
                            <th style="text-align:right"> Fitrah (Rp.) </th>
                            <th style="text-align:right"> Fitrah Beras (Kg.) </th>
                            <th style="text-align:right"> Infak (Rp.) </th>
                            <th style="text-align:right"> Sedekah (Rp.) </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receivements as $receivement)
                            <tr>
                                <td> {{ $loop->iteration }}. </td>
                                <td> {{ $receivement->muzakki->name }} </td>
                                <td>
                                    {{ $receivement->muzakki->address }} <br>
                                    Kecamatan {{ $receivement->muzakki->kecamatan }} <br>
                                    Kelurahan {{ $receivement->muzakki->kelurahan }}
                                </td>
                                <td style="text-align:right"> {{ \App\Helper\Formatter::currency($receivement->zakat) }} </td>
                                <td style="text-align:right"> {{ \App\Helper\Formatter::currency($receivement->fitrah) }} </td>
                                <td style="text-align:right"> {{ \App\Helper\Formatter::number($receivement->fitrah_beras) }} </td>
                                <td style="text-align:right"> {{ \App\Helper\Formatter::currency($receivement->infak) }} </td>
                                <td style="text-align:right"> {{ \App\Helper\Formatter::currency($receivement->sedekah) }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                        @if ($loop->last)
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right; font-weight: bold"> Total: </td>
                                    <td style="text-align: right"> {{ \App\Helper\Formatter::currency($receivement->sum("zakat")) }} </td>
                                    <td style="text-align: right"> {{ \App\Helper\Formatter::currency($receivement->sum("fitrah")) }} </td>
                                    <td style="text-align: right"> {{ \App\Helper\Formatter::number($receivement->sum("fitrah_beras")) }} </td>
                                    <td style="text-align: right"> {{ \App\Helper\Formatter::currency($receivement->sum("infak")) }} </td>
                                    <td style="text-align: right"> {{ \App\Helper\Formatter::currency($receivement->sum("sedekah")) }} </td>
                                </tr>
                            </tfoot>
                        @endif
                </table>
            </section>
        @endforeach
    </body>
@endsection
