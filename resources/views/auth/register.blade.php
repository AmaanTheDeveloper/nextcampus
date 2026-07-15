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

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4 bg-blue-900 hover:bg-blue-800">
                    {{ __('Register') }}
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
