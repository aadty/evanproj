<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-linear-to-br from-indigo-600 to-purple-700 min-h-screen flex justify-center items-center p-5">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-10 animate-fade-in">
        <!-- Logo Section -->
        <div class="text-center mb-10">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 mx-auto mb-3 object-contain">
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="list-none">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm text-red-700 mb-1">
                            <span class="font-bold">✕</span> {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Register Form -->
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Name Field -->
            <div class="mb-5">
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 transition-all duration-300 focus:outline-none focus:bg-gray-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 hover:border-gray-300"
                    placeholder="Username"
                    value="{{ old('name') }}" 
                    required
                    autocomplete="name"
                >
                @error('name')
                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-5">
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 transition-all duration-300 focus:outline-none focus:bg-gray-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 hover:border-gray-300"
                    placeholder="Email Address"
                    value="{{ old('email') }}" 
                    required
                    autocomplete="email"
                >
                @error('email')
                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="mb-5">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 transition-all duration-300 focus:outline-none focus:bg-gray-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 hover:border-gray-300"
                    placeholder="Password (min 6 characters)"
                    required
                    autocomplete="new-password"
                >
                @error('password')
                    <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-7">
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 transition-all duration-300 focus:outline-none focus:bg-gray-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 hover:border-gray-300"
                    placeholder="Confirm Password"
                    required
                    autocomplete="new-password"
                >
            </div>

            <!-- Register Button -->
            <button type="submit" class="w-full py-3 bg-blue-500 text-white rounded-xl font-semibold uppercase tracking-wide transition-all duration-300 hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 disabled:bg-slate-300 disabled:cursor-not-allowed disabled:transform-none">
                Register
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-gray-600 text-sm">Udah ada akun? <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:text-blue-600 hover:underline transition-colors">Login disini aja!</a></p>
        </div>
    </div>
</body>
</html>
