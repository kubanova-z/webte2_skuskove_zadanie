<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.updatePassword') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <label for="current_password" class="block font-medium text-sm text-gray-700">
                Current Password
            </label>
            <input id="current_password" name="current_password" type="password"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label for="password" class="block font-medium text-sm text-gray-700">
                New Password
            </label>
            <input id="password" name="password" type="password"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">
                Confirm Password
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition">
                Save
            </button>
        </div>
    </form>
</section>
