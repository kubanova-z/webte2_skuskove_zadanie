@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h2 class="text-2xl font-bold mb-4">{{ __('messages.change_password') }}</h2>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <label class="block font-medium text-sm text-gray-700 mt-2">{{ __('messages.current_password') }}</label>
                    <input name="current_password" type="password" class="block w-full mt-1 border rounded px-3 py-2" required>

                    <div class="relative mt-4">
                        <label for="password" class="block font-medium text-sm text-gray-700">{{ __('messages.new_password') }}</label>

                        <input id="password" name="password" type="password"
                               class="block w-full mt-1 border rounded px-3 py-2 pr-10 focus:ring focus:ring-blue-300"
                               required>

                        <button type="button"
                                onclick="toggleVisibility('password', this)"
                                class="absolute right-3 top-[27px] flex items-center h-8 text-gray-500 hover:text-gray-700">
                            <span class="material-symbols-outlined text-[22px] leading-none">visibility_off</span>
                        </button>
                    </div>

                    <div class="relative mt-4">
                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('messages.confirm_password') }}</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="block w-full mt-1 border rounded px-3 py-2 pr-10 focus:ring focus:ring-blue-300"
                               required>

                        <button type="button"
                                onclick="toggleVisibility('password_confirmation', this)"
                                class="absolute right-3 top-[27px] flex items-center h-8 text-gray-500 hover:text-gray-700">
                            <span class="material-symbols-outlined text-[22px] leading-none">visibility_off</span>
                        </button>
                    </div>

                    <button type="submit"
                            class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        {{ __('messages.save') }}
                    </button>

                    <button type="button"
                            onclick="generatePassword()"
                            class="mb-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow">
                        {{ __('messages.generate_password') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function generatePassword(length = 12) {
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?";
            let password = "";
            for (let i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(Math.floor(Math.random() * n));
            }

            document.querySelector('input[name="password"]').value = password;
            document.querySelector('input[name="password_confirmation"]').value = password;
        }

        function toggleVisibility(fieldId, button) {
            const field = document.getElementById(fieldId);
            const icon = button.querySelector('span');

            if (field.type === "password") {
                field.type = "text";
                icon.textContent = "visibility_off";
            } else {
                field.type = "password";
                icon.textContent = "visibility";
            }
        }
    </script>
@endsection
