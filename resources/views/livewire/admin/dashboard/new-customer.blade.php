<div>
    <div class="card">
        <div class="card-header">
            Pelanggan Terbaru dalam Minggu Ini
        </div>
        <div class="card-body">
            @if ($customers->isEmpty())
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    Tidak ada pelanggan baru yang terdaftar dalam minggu ini.
                </div>
            @else
                <x-dash.table headers="Nama, Alamat, Bergabung Pada">
                    @foreach ($customers as $customer)
                        <tr>
                            <td style="width: 25%;">{{ $customer->user->name }}</td>
                            <td title="{{ $customer->address }}">
                                {{ \Str::limit($customer->address, 60) }}
                            </td>
                            <td style="width: 30%;">{{ formatDate($customer->created_at, 'l, d M Y') }}</td>
                        </tr>
                    @endforeach
                </x-dash.table>
            @endif
        </div>
    </div>
</div>
