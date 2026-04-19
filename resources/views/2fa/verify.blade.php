<x-auth-layout>
    <div class="text-bold">Masukkan OTP</div>

    <form method="POST" action="{{ route('2fa.verify.post') }}">
        @csrf
        <input type="text" name="otp" class="form-control" placeholder="Kode OTP" autofocus required>
        <button type="submit" class="btn btn-block btn-primary mt-2">Verifikasi</button>
    </form>
</x-auth-layout>