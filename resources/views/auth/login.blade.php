<x-guest-layout>
    <style>
        .page-bg {
            background-image: url('/assets/media/images/background.jpg'); 
            background-size: cover;
            background-position: left bottom;
            background-repeat: no-repeat;
        }
 
    </style>

    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg min-h-screen">
        <div class="card max-w-[370px] w-full">
            <form method="POST" action="{{ route('login') }}" class="card-body flex flex-col gap-5 p-10">
                @csrf

                <div class="text-center mb-5">

                    <div class="mb-4 inline-flex items-center justify-center w-32 h-32 rounded-full   mx-auto">
                        <img src="{{ asset('assets/media/images/logopenon.png') }}" alt="">
                    </div>

                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Inicia Sesión</h1>
                </div>
                <x-validation-errors class="mb-4" />
                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-500">
                        {{ $value }}
                    </div>
                @endsession

                <div class="flex flex-col gap-1">
                    <label for="email" class="form-label font-normal text-gray-900 dark:text-gray-200">
                        Correo
                    </label>
                    <input id="email"
                           name="email"
                           type="email"
                           {{-- Aplica clase de error si existe para 'email' --}}
                           class="input @error('email') border-danger @enderror"
                           placeholder="{{ __('email@email.com') }}"
                           {{-- Mantiene el valor anterior en caso de error --}}
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username" />
                </div>

                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between gap-1">
                        <label for="password" class="form-label font-normal text-gray-900 dark:text-gray-200">
                            Contraseña
                        </label>
                    </div>

                    <div class="input @error('password') border-danger @enderror" data-toggle-password="true">
                        <input id="password"
                               name="password"
                               type="password"
                               {{-- Clases para que ocupe el espacio y no tenga borde propio --}}
                               class="border-0 focus:ring-0 w-full p-0"
                               placeholder="Escribe tu contraseña"
                               required
                               autocomplete="current-password" />

                        <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
                            <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"></i>
                            <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"></i>
                        </button>
                    </div>
                </div>

                <label class="checkbox-group" style=display:none>
                    <input id="remember_me" name="remember" type="checkbox" class="checkbox checkbox-sm" />
                    <span class="checkbox-label text-gray-700 dark:text-gray-300">
                        Recordarme
                    </span>
                </label>

                <button type="submit" class="btn btn-primary flex justify-center grow">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>