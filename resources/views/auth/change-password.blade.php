@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h2 class="text-2xl font-bold mb-4">Change Password</h2>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <label class="block font-medium text-sm text-gray-700 mt-2">Current Password</label>
                    <input name="current_password" type="password" class="block w-full mt-1 border rounded px-3 py-2" required>

                    {{--<label class="block font-medium text-sm text-gray-700 mt-4">New Password</label>
                    <input name="password" type="password" class="block w-full mt-1 border rounded px-3 py-2" required>--}}
                    <div class="relative mt-4">
                        <label for="password" class="block font-medium text-sm text-gray-700">New Password</label>

                        <input id="password" name="password" type="password"
                               class="block w-full mt-1 border rounded px-3 py-2 pr-10 focus:ring focus:ring-blue-300"
                               required>

                        <button type="button"
                                onclick="toggleVisibility('password', this)"
                                class="absolute right-3 top-[27px] flex items-center h-8 text-gray-500 hover:text-gray-700">
                            <span class="material-symbols-outlined text-[22px] leading-none">visibility_off</span>
                        </button>
                    </div>




                    {{--<label class="block font-medium text-sm text-gray-700 mt-4">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="block w-full mt-1 border rounded px-3 py-2" required>--}}

                    <div class="relative mt-4">
                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="block w-full mt-1 border rounded px-3 py-2 pr-10 focus:ring focus:ring-blue-300"
                               required>

                        <button type="button"
                                onclick="toggleVisibility('password', this)"
                                class="absolute right-3 top-[27px] flex items-center h-8 text-gray-500 hover:text-gray-700">
                            <span class="material-symbols-outlined text-[22px] leading-none">visibility_off</span>
                        </button>

                    </div>



                    <button type="submit"
                            class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Save
                    </button>

                    <button type="button"
                            onclick="generatePassword()"
                            class="mb-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow">
                        Generate Strong Password
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

            // Fill the form fields
            document.querySelector('input[name="password"]').value = password;
            document.querySelector('input[name="password_confirmation"]').value = password;
        }
    </script>

    <script>
        function toggleVisibility(fieldId, button) {
            const field = document.getElementById(fieldId);
            const icon = button.querySelector('span');

            if (field.type === "password") {
                field.type = "text";
                icon.textContent = "visibility_off"; // show crossed eye
            } else {
                field.type = "password";
                icon.textContent = "visibility"; // show normal eye
            }
        }
    </script>



@endsection


