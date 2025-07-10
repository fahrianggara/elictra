<div class="table-responsive">
    <div class="rounded border">
        <table class="table mb-0">
            @if ($headers)
                <thead class="table-light">
                    <tr>
                        @foreach (explode(',', $headers) as $header)
                            <th>{{ trim($header) }}</th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
