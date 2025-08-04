<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{--    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>--}}

    <!-- Scripts -->
    @vite(['resources/css/app.css'])

</head>
<body class="bg-gray-100">
<div class="flex justify-center px-6  py-12 lg:px-8">
    <div class="bg-white p-4 w-96 border border-gray-200 px-6 rounded-md">
        <div>
            <div class="flex items-center justify-center">
                <x-application-logo/>
            </div>
            <h2 class="text-center mt-8 text-xl font-bold leading-9 tracking-tight text-gray-900">
                Login to your account
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

            <form id="login-form" method="POST" action="{{ route('auth.login') }}">
                @csrf

                <!-- Email/Username -->
                <div>
                    <x-input-label for="username" :value="__('Username')"/>
                    <x-text-input id="username"
                                  class="block mt-1 w-full"
                                  type="text"
                                  name="identifier"
                                  :value="old('username')"
                                  required
                                  autofocus
                                  autocomplete="username"/>
                    <x-input-error :messages="$errors->get('identifier')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')"/>
                    <x-text-input id="password"
                                  class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required
                                  autocomplete="current-password"/>
                    <x-input-error :messages="$errors->get('password')"/>
                </div>

                <p id="login-error" class="text-red-600 my-2 invisible ">Incorrect username or password</p>

                <div class="flex items-center justify-end">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div>
                    <x-primary-button class="w-full justify-center loading-btn mt-6">
                        <div class="loading hidden">
                            <div class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Loading
                            </div>
                        </div>
                        <div class="button-text">
                            {{ __('Log in') }}
                        </div>
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    window.addEventListener('load', function () {
        function toggleLoadingButton() {
            const loadingButton = document.querySelector('.loading-btn');
            const loading = loadingButton.querySelector('.loading');
            const buttonText = loadingButton.querySelector('.button-text');
            loading.classList.toggle('hidden');
            buttonText.classList.toggle('hidden');
        }

        function disableLoginForm() {
            const loginForm = document.getElementById('login-form');
            const inputs = loginForm.querySelectorAll('input');
            inputs.forEach(input => {
                input.readOnly = true;
            });
        }

        function enableLoginForm() {
            const loginForm = document.getElementById('login-form');
            const inputs = loginForm.querySelectorAll('input');
            inputs.forEach(input => {
                input.readOnly = false;
            });
        }

        let isLoggingIn = false
        const loginForm = document.getElementById('login-form');

        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (isLoggingIn) {
                return;
            }
            disableLoginForm()
            isLoggingIn = true
            toggleLoadingButton()
            const formData = new FormData(loginForm);
            fetch(loginForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            }).then(response => {
                if (response.ok) {
                    window.location.href = '{{ route('app') }}';
                } else {
                    throw new Error();
                }
            }).catch(error => {
                console.log('Error:', error);
                isLoggingIn = false
                enableLoginForm()
                toggleLoadingButton()
                document.getElementById('login-error').classList.remove('invisible');
            });
        });
    })
</script>
</body>
</html>
