<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Create your account</h1>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-text-input 
                    id="name" 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    placeholder="Name"
                    required 
                    autofocus 
                    autocomplete="name" 
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <x-text-input 
                    id="email" 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    placeholder="Email address"
                    required 
                    autocomplete="username" 
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-text-input 
                    id="password" 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    type="password"
                    name="password"
                    placeholder="Password"
                    required 
                    autocomplete="new-password" 
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-text-input 
                    id="password_confirmation" 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm password"
                    required 
                    autocomplete="new-password" 
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Register Button -->
            <div class="mb-4">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                    Register
                </button>
            </div>
            <!-- Login Link -->
            <div class="text-center">
                <span class="text-sm text-gray-600">Already have an account? </span>
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">
                    Sign in
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>