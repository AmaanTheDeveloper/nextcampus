<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden p-8 text-center">
            
            <div class="mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 mb-4">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900">Verify your email</h2>
                <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                    {{ __('Before continuing, please verify your email address by clicking on the link we just emailed to you. If you didn\'t receive the email, we will gladly send you another.') }}
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 rounded-lg bg-green-50 text-sm text-green-700 font-medium">
                    {{ __('A new verification link has been sent to the email address you provided.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" 
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-center gap-4">
                <a href="{{ route('profile.show') }}" class="text-sm text-gray-500 hover:text-indigo-600 font-medium underline">
                    Edit Profile
                </a>
                <span class="text-gray-300">|</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium underline">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>