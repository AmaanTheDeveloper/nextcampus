<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <h2 class="text-3xl font-extrabold text-blue-900">Next<span class="text-blue-500">Campus</span></h2>
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Full Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email Address') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="phone" value="{{ __('Phone Number (Optional)') }}" />
                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
            </div>

            <div class="mt-4">
                <x-label for="role" value="{{ __('Register As') }}" />
                <select id="role" name="role" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm block mt-1 w-full" required onchange="handleRoleChange(this.value)">
                    <option value="student">{{ __('Student') }}</option>
                    <option value="teacher">{{ __('Teacher') }}</option>
                    <option value="company">{{ __('Company (Employer)') }}</option>
                    <option value="club_leader">{{ __('Club Leader') }}</option>
                </select>
            </div>

            <div class="mt-4" id="dynamic-field-wrapper">
                <x-label id="dynamic-label" for="extra_name" value="{{ __('Institute Name') }}" />
                <x-input id="extra_name" class="block mt-1 w-full" type="text" name="extra_name" :value="old('extra_name')" required />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif
<div class="mt-6">
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="bg-white px-3 text-gray-500">OR</span>
        </div>
    </div>

    <a href="{{ route('googlelogin') }}"
       class="mt-6 w-full flex items-center justify-center gap-3 px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition duration-200">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5">
            <path fill="#FFC107" d="M43.6 20H42V20H24v8h11.3C33.6 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12S17.4 12 24 12c3 0 5.8 1.1 7.9 3l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-4z"/>
            <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.6 19 12 24 12c3 0 5.8 1.1 7.9 3l5.7-5.7C34.1 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
            <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.6-5.3l-6.3-5.2C29.3 35.1 26.8 36 24 36c-5.2 0-9.6-3.3-11.3-8H6.2C9.5 37.1 16.1 44 24 44z"/>
            <path fill="#1976D2" d="M43.6 20H42V20H24v8h11.3c-1.1 3.1-3.3 5.5-6 6.9l6.3 5.2C39.7 36.4 44 30.8 44 24c0-1.3-.1-2.7-.4-4z"/>
        </svg>

        <span class="font-medium text-gray-700">
            Continue with Google
        </span>
    </a>
</div>

<div class="flex items-center justify-between mt-6">
    <a class="underline text-sm text-gray-600 hover:text-blue-700"
       href="{{ route('login') }}">
        Already registered?
    </a>

    <x-button class="bg-blue-900 hover:bg-blue-800">
        Register
    </x-button>
</div>
        </form>

        <script>
            function handleRoleChange(role) {
                const label = document.getElementById('dynamic-label');
                const input = document.getElementById('extra_name');
                
                if (role === 'student') {
                    label.innerText = 'Institute Name';
                    input.placeholder = 'e.g. Aptech Institute';
                } else if (role === 'teacher') {
                    label.innerText = 'Department / Subject';
                    input.placeholder = 'e.g. Computer Science';
                } else if (role === 'company') {
                    label.innerText = 'Company Name';
                    input.placeholder = 'e.g. Google DeepMind';
                } else if (role === 'club_leader') {
                    label.innerText = 'Club / Society Name';
                    input.placeholder = 'e.g. ACM Student Chapter';
                }
            }
            // Trigger initial
            document.addEventListener('DOMContentLoaded', () => {
                handleRoleChange(document.getElementById('role').value);
            });
        </script>
    </x-authentication-card>
</x-guest-layout>
