<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Device</th>
            <th>Tegangan AC (V)</th>
            <th>Arus AC (A)</th>
            <th>Tegangan DC (V)</th>
            <th>Suhu (°C)</th>
            <th>Kelembapan (%RH)</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($monitorings as $monitoring)
            <tr>
                <td>{{ $monitoring->recorded_at->format('Y-m-d') }}</td>
                <td>{{ $monitoring->recorded_at->format('H:i:s') }}</td>
                <td>{{ $monitoring->device->device_name ?? $monitoring->device->device_code }}</td>
                <td>{{ $monitoring->ac_voltage }}</td>
                <td>{{ $monitoring->ac_current }}</td>
                <td>{{ $monitoring->dc_voltage }}</td>
                <td>{{ $monitoring->temperature }}</td>
                <td>{{ $monitoring->humidity }}</td>
                <td>{{ ucfirst($monitoring->status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
