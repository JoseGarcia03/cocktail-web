<x-guest-layout>
    <div class="min-h-screen bg-gray-100 flex">
        <div class="w-full lg:w-1/2 flex items-center justify-center p-0 md:p-4 lg:p-16">
            <div class="max-w-md w-full bg-white rounded-lg md:border md:border-gray-300 shadow-default py-2 px-4 md:py-6 md:px-10 xl:py-10 xl:px-16">
                <div>
                    <h1 class="text-2xl font-medium text-primary mt-4 mb-12 text-center">Iniciar Sesión</h1>
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <label for="remember_me" class="ms-2 block text-sm text-gray-900">Recuérdame</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-blue-500 hover:underline" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <div class="mt-6">
                            <x-primary-button class="w-full justify-center">
                                Iniciar Sesión
                            </x-primary-button>
                        </div>

                        <div class="flex items-center justify-center mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                                ¿No tienes una cuenta? Regístrate
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="hidden lg:block lg:w-1/2 bg-gradient-to-r from-green-400 to-blue-500 text-white flex flex-col justify-center items-center p-16">
            <div class="lg:block h-full max-h-screen flex items-center justify-center bg-center bg-no-repeat" style="background-image: url('/images/cocktail.png'); background-size: contain;">
            </div>
        </div>
    </div>
</x-guest-layout>
