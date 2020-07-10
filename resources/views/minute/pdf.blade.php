<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $minute->agenda }}</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
        }

        .judul {
            font-size: 1.5rem;
        }

        .subjudul {
            font-size: 1.2rem;
        }

        .judul, .subjudul {
            text-align: center;
        }

        .tabel-keterangan {
            width: 320px;
            margin: 0 auto;
        }

        .tabel-keterangan td {
            padding: .1rem;
            vertical-align: baseline;
        }

        .konten {
            margin: 1rem 0;
            padding: .5rem 1.2rem;
            border: 1px solid black;
        }

        .konten p {
            margin-top: 0;
            margin-bottom: .8rem;
        }
    </style>
</head>
<body>
    <h1 class="judul">{{ $minute->agenda }}</h1>
    <h2 class="subjudul">Universitas Muhammadiyah Yogyakarta</h2>
    <table class="tabel-keterangan">
        <tr>
            <td>Hari</td>
            <td>:</td>
            <td>{{ $minute->meeting_date->translatedFormat('l') }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ $minute->meeting_date->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Pukul</td>
            <td>:</td>
            <td>{{ $minute->start_at->translatedFormat('H:i') . ' s.d ' . $minute->end_at->translatedFormat('H:i') . ' WIB' }}</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>:</td>
            <td>{{ $minute->room->name }}</td>
        </tr>
        <tr>
            <td>Agenda</td>
            <td>:</td>
            <td>{{ $minute->agenda }}</td>
        </tr>
    </table>
    <div class="konten">
        {!! $minute->note !!}
        @if($minute->presents->isNotEmpty())
            <div class="peserta">
                <p>Hadir:</p>
                <ol>
                    @foreach($minute->presents->map(function ($present) { return ['name' => $present->lecturer->name]; })->sortBy('name') as $present)
                        <li>{{ $present['name'] }}</li>
                    @endforeach
                </ol>
            </div>
        @endif
    </div>
    <table style="width: 100%">
        <tr>
            <td style="text-align: center">
                <p style="margin-bottom: 4rem">Pimpinan Rapat</p>
                <p>{{ $minute->lecturer->name }}</p>
            </td>
            <td></td>
            <td style="text-align: center">
                <p style="margin-bottom: 4rem">Notulis</p>
                <p>{{ $minute->notulis->name ?? '(...........................)' }}</p>
            </td>
        </tr>
    </table>
</body>
</html>
