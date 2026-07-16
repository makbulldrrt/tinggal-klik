<x-guest-layout>
    <div class="mb-6 text-sm text-gray-600 text-center leading-relaxed">
        {{ __('Terimakasih sudah mendaftar di Tinggal Klik! Sebelum anda bisa login, anda harus verifikasi email anda terlebih dahulu dengan mengklik verifikasi link di email anda yang sudah kami kirimkan. Jika anda tidak menerima pesan verifikasi emai, anda bisa mengklik tombol resend verification email dibawah .') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-medium text-sm text-teal-600 bg-teal-50 p-4 rounded-lg text-center border border-teal-200">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf

            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-teal-500 border border-transparent rounded-full font-semibold text-sm text-white uppercase tracking-widest hover:bg-teal-600 focus:bg-teal-600 active:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
            @csrf

            <button type="submit" class="w-full sm:w-auto underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 text-center">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
