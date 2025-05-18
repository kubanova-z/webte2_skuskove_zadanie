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

                    <label class="block font-medium text-sm text-gray-700 mt-4">New Password</label>
                    <input name="password" type="password" class="block w-full mt-1 border rounded px-3 py-2" required>

                    <label class="block font-medium text-sm text-gray-700 mt-4">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="block w-full mt-1 border rounded px-3 py-2" required>

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

@endsection


