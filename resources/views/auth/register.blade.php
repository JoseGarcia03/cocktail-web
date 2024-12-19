<x-guest-layout>
    <div class="min-h-screen bg-gray-100 flex">
        <div class="w-full lg:w-1/2 flex items-center justify-center p-0 md:p-4 lg:p-16">
            <div class="max-w-md w-full bg-white rounded-lg md:border md:border-gray-300 shadow-default py-2 px-4 md:py-6 md:px-10 xl:py-10 xl:px-16">
                <div>
                    <h1 class="text-2xl font-medium text-primary mt-4 mb-12 text-center">Registro</h1>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Correo Electrónico')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Contraseña')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirme la contraseña')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                                {{ __('¿Ya tienes una cuenta?') }}
                            </a>

                            <x-primary-button class="ms-4">
                                {{ __('Registrarse') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="hidden lg:block lg:w-1/2 bg-gradient-to-r from-green-400 to-blue-500 text-white p-16">
            <div class="lg:block h-full max-h-screen flex items-center justify-center bg-center bg-no-repeat" style="background-image: url('/images/cocktail-register.png'); background-size: contain;">
            </div>
        </div>
    </div>
</x-guest-layout>
