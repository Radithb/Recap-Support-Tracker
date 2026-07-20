<?php
// Mencegah spasi kosong tambahan
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #e2efda;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th style="width: 250px; background-color: #e2efda; font-weight: bold; border: 1px solid #000000;">Nama Koperasi</th>
                <th style="width: 150px; background-color: #e2efda; font-weight: bold; border: 1px solid #000000;">Jenis Case</th>
                <th style="width: 150px; background-color: #e2efda; font-weight: bold; border: 1px solid #000000;">Jenis Aplikasi</th>
                <th style="width: 150px; background-color: #e2efda; font-weight: bold; border: 1px solid #000000;">PIC TIM SUPPORT</th>
                <th style="width: 120px; background-color: #e2efda; font-weight: bold; border: 1px solid #000000;">Status</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < $maxRows; $i++)
                <tr>
                    <td style="border: 1px solid #000000;">{{ isset($instansis[$i]) ? $instansis[$i]->nama_instansi : '' }}</td>
                    <td style="border: 1px solid #000000;">{{ isset($kategoris[$i]) ? $kategoris[$i]->nama_kategori : '' }}</td>
                    <td style="border: 1px solid #000000;">{{ isset($aplikasis[$i]) ? $aplikasis[$i]->nama_aplikasi : '' }}</td>
                    <td style="border: 1px solid #000000;">{{ isset($supportPics[$i]) ? $supportPics[$i]->nama : '' }}</td>
                    <td style="border: 1px solid #000000;">{{ isset($statuses[$i]) ? $statuses[$i]->value : '' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>
