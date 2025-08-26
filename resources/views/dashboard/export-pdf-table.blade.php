<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ucfirst($tab) }} Items PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <div style="text-align: center;">
            <h2 style="margin: 0; font-size: 20px;">BOOK LIST</h2>
        </div>
        
        <table style="width: 100%; font-size: 12px; margin-bottom: 10px; border: 0; border-collapse: collapse;">
            <tr style="border: none;">
                <td style="text-align: left; border: 0; background: none;">Export By: {{ $user->name }}</td>
                <td style="text-align: right; border: 0; background: none;">Print Date & Time: {{ now()->format('d-m-Y H:i') }}</td>
            </tr>
        </table>


    </div>

    <table>
        <thead>
            <tr>
                <th>Sl.</th>
                <th>Book Name</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->order_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
