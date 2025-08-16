<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ ucfirst($tab) }} Items PDF</title>
    <style type="text/css" media="all">
        body {
            width: 100%;
            margin: 20px;
            padding: 0;
            background-color: #FAFAFA;
            font-family: "Tahoma", sans-serif;
            font-size: 12pt;
        }

        @page {
            size: A4;
            margin: 20px;
        }

        .card {
            width: 30%;
            margin: 1.5%;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            overflow: hidden;
            position: relative;
            float: left;
        }

        .card img {
            width: 100%;
            height: auto;
            display: block;
        }

        .badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: red;
            color: white;
            padding: 4px 7px;
            font-size: 10pt;
            font-weight: bold;
            border-radius: 50%;
            line-height: 1;
        }

        .card-title {
            font-size: 11pt;
            padding: 8px;
            text-align: center;
            word-wrap: break-word;
            white-space: normal;   
        }

      
        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    @php $count = 0; @endphp
    @foreach($items as $item)
        <div class="card">
            <img src="{{ str_replace('/w80/', '/s800/', $item->thumb) }}" alt="Image">
            <div class="badge">{{ $item->order_count }}</div>
            <div class="card-title">{{ $item->title }}</div>
        </div>
        @php $count++; @endphp
        @if($count % 3 == 0)
            <div class="clear"></div>
        @endif
    @endforeach
</body>

</html>
