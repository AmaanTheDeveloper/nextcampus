<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden p-8">
            
            <!-- Heading -->
            <div class="text-center mb-6">
                <h2 class="text-3xl font-extrabold text-gray-900">Forgot Password?</h2>
                <p class="text-gray-500 mt-2 text-sm">
                    No problem. Just enter your email and we'll send you a reset link.
                </p>
            </div>

            @session('status')
                <div class="mb-4 p-4 rounded-lg bg-green-50 text-sm text-green-700 font-medium">
                    {{ $value }}
                </div>
            @endsession

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition">
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200">
                    {{ __('Email Password Reset Link') }}
                </button>

                <!-- Back to Login Link -->
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-indigo-600 font-medium">
                        ← Back to login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>