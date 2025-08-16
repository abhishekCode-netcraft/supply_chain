<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ ucfirst($tab) }} Items PDF</title>
    <style type="text/css" media="all">
        body {
            margin: 20px;
            background-color: #FAFAFA;
            font-family: "Tahoma", sans-serif;
            font-size: 12pt;
        }

        @page {
            size: A4;
            margin: 20px;
        }

        table {
            width: 100%;
            border-spacing: 10px;
            page-break-inside: auto;
        }

        td {
            width: 33%;
            vertical-align: top;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
            text-align: center;
        }

        .card-img {
            width: 100%;
            max-height: 250px;
            object-fit: contain;
            display: block;
        }

        .badge {
            position: relative;
            top: -35px;
            left: calc(100% - 40px);
            background-color: red;
            color: white;
            padding: 5px 8px;
            font-size: 10pt;
            font-weight: bold;
            border-radius: 50%;
            line-height: 1;
            display: inline-block;
        }

        .card-title {
            font-size: 11pt;
            padding: 8px;
            word-wrap: break-word;
            white-space: normal;
            margin-top: -20px; /* badge ke niche space adjust */
        }
    </style>
</head>

<body>
    <table>
        <tr>
            @php $col = 0; @endphp
            @foreach($items as $item)
                <td>
                    <img class="card-img" src="{{ str_replace('/w80/', '/s800/', $item->thumb) }}" alt="Image">
                    <div class="badge">{{ $item->order_count }}</div>
                    <div class="card-title">{{ $item->title }}</div>
                </td>
                @php $col++; @endphp

                @if($col % 3 == 0)
                    </tr><tr>
                @endif
            @endforeach
        </tr>
    </table>
</body>

</html>
