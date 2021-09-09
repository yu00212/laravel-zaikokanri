<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <h2 class="flex justify-center font-semibold text-xl text-gray-800 leading-tight mb-4">
            ユーザーログイン
        </h2>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('メールアドレス') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('パスワード') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('次回から省略') }}</span>
                    <div class="ml-10 underline text-sm text-gray-600 hover:text-gray-900">
                        <a href="/register">新規作成はこちら</a>
                    </div>
                </label>
            </div>

            <div class="mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('パスワードを忘れた方はこちら') }}
                    </a>
                @endif
            </div>

            <div class="flex justify-center">
                <x-jet-button class="mt-8">
                    {{ __('ログイン') }}
                </x-jet-button>
            </div>
        </form>

            <div class="flex justify-center">
                <x-jet-button class="mt-6 mb-2">
                    <a class="-py-12" href="/guest">
                    ゲストログイン
                    </a>
                </x-jet-button>
            </div>
    </x-jet-authentication-card>
</x-guest-layout>
