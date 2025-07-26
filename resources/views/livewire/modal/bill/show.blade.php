<div class="bill-detail">
    <table>
        <tr>
            <td>Pelanggan</td>
            <td>:</td>
            <td>{{ $bill->customer->user->name }}</td>
        </tr>
        <tr>
            <td>No Meteran</td>
            <td>:</td>
            <td>{{ $bill->customer->meter_number }}</td>
        </tr>
        <tr>
            <td>Tarif</td>
            <td>:</td>
            <td>{{ $bill->customer->tarif->format_tarif }}</td>
        </tr>
        <tr>
            <td>Periode</td>
            <td>:</td>
            <td>{{ formatPeriod($bill->period) }}</td>
        </tr>
        <tr>
            <td>No. Invoice</td>
            <td>:</td>
            <td>{{ $bill->invoice }}</td>
        </tr>
        <tr>
            <td>Meter Awal</td>
            <td>:</td>
            <td>{{ $bill->meter_start }}</td>
        </tr>
        <tr>
            <td>Meter Akhir</td>
            <td>:</td>
            <td>{{ $bill->meter_end }}</td>
        </tr>
        <tr>
            <td>Pemakaian</td>
            <td>:</td>
            <td>{{ $bill->usage }} kWh</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $bill->status_format }}</td>
        </tr>
        <tr>
            <td>Jatuh Tempo</td>
            <td>:</td>
            <td>{{ formatDate($bill->due_date, 'l, d F Y') }}</td>
        </tr>
        <tr>
            <td>Harga/kWh</td>
            <td>:</td>
            <td>{{ rupiah($bill->customer->tarif->price_per_kwh) }}</td>
        </tr>
        <tr>
            <td class="bold">Total Tagihan</td>
            <td>:</td>
            <td class="bold">{{ rupiah($bill->amount) }}</td>
        </tr>
    </table>
</div>
