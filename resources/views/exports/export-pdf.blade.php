<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ ucfirst($tab) }} Items PDF</title>
    <style type="text/css" media="all">
        body {
            margin: 10px;
            background-color: #FAFAFA;
            font-family: "Tahoma", sans-serif;
            font-size: 9pt;
        }

        @page {
            size: A4;
            margin: 15px;
        }

        table {
            width: 100%;
            border-spacing: 6px;
            page-break-inside: auto;
        }

        td {
            width: 20%; /* 5 columns ek row me */
            vertical-align: top;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            padding: 4px;
            position: relative;
            font-size: 8pt;
        }

        .img-holder {
            width: 100%;
            height: 100px; /* chhota kiya taki rows fit ho */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .card-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
        }

        .badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background-color: #d33;
            color: #fff;
            padding: 3px 6px;
            font-size: 8pt;
            font-weight: bold;
            border-radius: 10px;
            line-height: 1;
        }

        .card-title {
            font-size: 8pt;
            padding: 4px 2px;
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            @php $col = 0; @endphp
            @foreach($items as $item)
                <td>
                    <div class="img-holder">
                        @php
                            $src = $item->thumb ?: $item->clean_thumb;
                            if ($src) {
                                $src = str_replace('/w80/', '/s800/', $src);
                            }
                        @endphp
                        @if($src)
                            <img class="card-img" src="{{ $src }}" alt="Image">
                        @endif
                    </div>
                    <div class="badge">{{ $item->order_count }}</div>
                    <div class="card-title">{{ $item->title }}</div>
                </td>

                @php $col++; @endphp
                @if($col % 5 == 0)
                    </tr><tr>
                @endif
            @endforeach
        </tr>
    </table>
</body>

</html>
