@extends('shared.print-layout')

@section('title', 'Print DATA MUSTAHIK DAN MUZAKI')

@section('extra-style')
    <style>
        @page { size: A4 landscape }
    </style>
@endsection

@section('content')
    <body class="A4 landscape">
        @foreach ($recordRowChunks as $recordRowChunk)
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
                        @foreach ($recordRowChunk as $recordRow)
                            <tr>
                                <td> {{ ($loop->parent->index * $rowPerPage) + $loop->iteration }}. </td>
                                <td> {{ $recordRow["value"]->name ?? null }} </td>
                                <td>
                                    {{ $recordRow["value"]->address ?? null }} <br>
                                    Kecamatan {{ $recordRow["value"]->kecamatan ?? null }} <br>
                                    Kelurahan {{ $recordRow["value"]->kelurahan ?? null }}
                                </td>
                                <td style="text-align:right"> {{ \App\Helper\Formatter::currency($recordRow["value"]->amount ?? 0) }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endforeach
    </body>
@endsection
