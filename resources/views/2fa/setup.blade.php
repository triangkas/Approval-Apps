<x-auth-layout>
    <div class="text-bold">Aktifkan 2FA</div>
    
    <div class="pt-1">1) Scan QR di aplikasi authenticator</div>
    <img src="{{ $qr }}" style="height: 125px;" alt="QR Code">
    
    <div class="pt-1">2) Atau masukkan kode manual ini:</div>
    <div style="padding:10px;background:#f5f5f5;font-size:20px;letter-spacing:1.5px;">
        {{ $secret }}
    </div>

    <p style="font-size:12px;color:gray;">
        Jika tidak bisa scan QR, pilih <b>Enter a setup key</b> di Google Authenticator,
        lalu masukkan kode di atas.
    </p>
    
    <hr />

    <form method="POST" action="{{ route('2fa.enable') }}">
        @csrf
        <input type="text" name="otp" class="form-control" placeholder="Masukkan 6 digit OTP" required autofocus>
        <button type="submit" class="btn btn-block btn-primary mt-2">Aktifkan 2FA</button>
    </form>
</x-auth-layout>