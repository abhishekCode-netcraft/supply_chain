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
            text-align: center;
            padding: 8px;
            position: relative;
         
        }

     
        .img-holder {
            width: 100%;
            height: 220px;
          
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
            top: 6px;
            right: 6px;
            background-color: #d33;
            color: #fff;
            padding: 5px 10px;
            font-size: 10pt;
            font-weight: bold;
            border-radius: 12px;
            line-height: 1;
        }

        .card-title {
            font-size: 11pt;
            padding: 8px 4px 2px;
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
                    <img class="card-img" src="{{ $src }}" alt="Image">
                </div>
                <div class="badge">{{ $item->order_count }}</div>
                <div class="card-title">{{ $item->title }}</div>
            </td>

            @php $col++; @endphp
            @if($col % 3 == 0)
        </tr>
        <tr>
            @endif
            @endforeach
        </tr>
    </table>
</body>

</html>