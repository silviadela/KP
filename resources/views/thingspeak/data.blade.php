<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thingspeak Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="clock" id="clock">Memuat jam...</div>
    <h1>Dashboard Thingspeak</h1>

    <div class="chart-row">
        <div class="chart-container">
            <h3>Grafik Suhu (°C)</h3>
            <canvas id="tempChart"></canvas>
        </div>
        <div class="chart-container">
            <h3>Grafik Kelembapan (%)</h3>
            <canvas id="humidChart"></canvas>
        </div>
    </div>

    <div class="card">
        <h2>Jumlah Data Masuk: <span id="jumlah-data">{{ $feeds->count() }}</span></h2>
    </div>

    <h2>Data Terbaru</h2>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Suhu (°C)</th>
                <th>Kelembapan (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feeds as $item)
                <tr>
                    <td>{{ $item['created_at'] }}</td>
                    <td>{{ $item['field2'] }}</td>
                    <td>{{ $item['field3'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        const labels = @json($feeds->pluck('created_at')->map(fn($time) => $time));
        const suhuData = @json($feeds->pluck('field2'));
        const kelembapanData = @json($feeds->pluck('field3'));
    </script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
