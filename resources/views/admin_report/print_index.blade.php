@php
    use App\Helper\Formatter;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Laporan Pendistribusian Zakat Tahun {{ $year }} </title>
    <link rel="stylesheet" href="{{ asset('css/paper.css') }}">
    <style>@page { size: A4 }</style>
    <style>
        table {
            width: 100%;
            border: thin solid black;
            border-collapse: collapse;
        }

        table td, table th {
            border: thin solid black;
            padding: 0.2rem;
        }
    </style>
</head>
<body class="A4">
    <section class="sheet padding-10mm">
        <h1 style="text-align: center"> LAPORAN PENERIMAAN ZAKAT TAHUN {{ $year }} </h1>

        <table>
            <thead>
                <tr>
                    <th> # </th>
                    <th> UPZ</th>
                    <th> Nomor Registrasi </th>
                    <th style="text-align: right"> Penerimaan (Rp.) </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($collectors as $collector)
                <tr>
                    <td> {{ $loop->iteration }}. </td>
                    <td> {{ $collector->name }} </td>
                    <td> {{ $collector->reg_number }} </td>
                    <td style="text-align:right"> {{ Formatter::currency($collector->report_total_amount["value"] ?? 0) }} </td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: right; font-weight: bold"> Total: </td>
                    <td style="text-align: right"> {{ Formatter::currency($collectors->sum('report_total_amount.value')) }} </td>
                </tr>
            </tbody>
        </table>

    </section>
</body>
</html>
