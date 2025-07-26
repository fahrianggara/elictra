@extends('print')

@section('title', $title)

@section('content')

    <div style="text-align:center; margin-bottom: 10px; padding-bottom: 10px;">
        <strong style="font-size: 20px;">{{ config('app.name') }}</strong>
        <br>
        <p style="margin: 0;">Aplikasi Pembayaran Pasca Bayar</p>
    </div>

    <hr>

    <h2 style="padding-top: 10px;">STRUK PEMBAYARAN</h2>
    <h4 style="margin-top: 5px;">Tagihan Listrik</h4>

    <div class="section">
        <strong>Informasi Pelanggan</strong>
        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td class="bold">{{ $user->name }}</td>
            </tr>
            <tr>
                <td>No. Meter</td>
                <td>:</td>
                <td>{{ $customer->meter_number }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $customer->address }}</td>
            </tr>
            <tr>
                <td>Tarif / Daya</td>
                <td>:</td>
                <td>{{ $tarif->type }} / {{ $tarif->power }} VA</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <strong>Detail Tagihan</strong>
        <table>
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
                <td>Harga/kWh</td>
                <td>:</td>
                <td>{{ rupiah($tarif->price_per_kwh) }}</td>
            </tr>
            <tr>
                <td class="bold">Total Tagihan</td>
                <td>:</td>
                <td class="bold">{{ rupiah($bill->amount) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <strong>Informasi Pembayaran</strong>
        <table>
            <tr>
                <td>Tanggal Bayar</td>
                <td>:</td>
                <td>{{ formatDate($payment->created_at, 'l, d F Y H:i') }}</td>
            </tr>
            <tr>
                <td>Metode</td>
                <td>:</td>
                <td>{{ $method->type_format }} - {{ $method->name }}</td>
            </tr>
            <tr>
                <td>No. Rekening</td>
                <td>:</td>
                <td>{{ $method->number }}</td>
            </tr>
            <tr>
                <td>Biaya Admin</td>
                <td>:</td>
                <td>{{ rupiah($method->fee) }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td>
                    {{ $payment->status_format }}
                    @if($payment->status == 'verified')
                        / Lunas
                    @endif
                </td>
            </tr>
            <tr>
                <td class="bold">Total Dibayar</td>
                <td>:</td>
                <td class="bold">{{ rupiah($payment->amount) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dicetak pada: {{ date('Y-m-d H:i:s') }}<br>
        Terima kasih telah melakukan pembayaran tepat waktu.
    </div>

@endsection
