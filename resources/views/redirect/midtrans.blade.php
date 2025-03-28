<!DOCTYPE html>
<html>

<head>
    <title>Midtrans Payment</title>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.clientKey') }}"></script>
</head>

<body>
    <script type="text/javascript">
        // Memanggil Snap
        snap.pay('{{ $snapToken }}', {
            // Optional
            onSuccess: function(result) {
                window.location.href = "{{ route('assign.pending.orders.redirect') }}";
            },
            onPending: function(result) {
                window.location.href = "{{ route('user') }}?status=Pembayaran+gagal!";
            },
            onError: function(result) {
                window.location.href = "{{ route('user') }}?status=Pembayaran+gagal!";
            },
            onClose: function(result) {
                window.location.href = "{{ route('user') }}?status=Pembayaran+dibatalkan!";
            }
        });
    </script>
</body>

</html>
