<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-linear-to-br from-indigo-600 to-purple-700 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 sm:p-12 animate-fade-in">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 mx-auto mb-3 object-contain">
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <ul class="space-y-2">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-700 text-sm flex items-start">
                            <span class="font-bold mr-2">✕</span>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Username/Email Field -->
            <div>
                <input 
                    type="text" 
                    id="email" 
                    name="email" 
                    class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-300 rounded-lg text-base font-family-segoe transition-all duration-300 focus:outline-none focus:bg-gray-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 hover:border-gray-400"
                    placeholder="Username or Email"
                    value="{{ old('email') }}" 
                    required
                    autocomplete="username"
                >
                @error('email')
                    <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-300 rounded-lg text-base font-family-segoe transition-all duration-300 focus:outline-none focus:bg-gray-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 hover:border-gray-400"
                    placeholder="Password"
                    required
                    autocomplete="current-password"
                >
                @error('password')
                    <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Login Button -->
            <button 
                type="submit" 
                class="w-full py-3 bg-blue-500 text-white font-bold rounded-lg text-base uppercase tracking-wide transition-all duration-300 hover:bg-blue-600 hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0 disabled:bg-slate-400 disabled:cursor-not-allowed"
            >
                Login
            </button>
        </form>

        <!-- Register Link -->
        {{-- <div class="mt-6 pt-5 border-t border-gray-100 text-center">
            <p class="text-gray-600 text-sm">
                Belum ada akun? 
                <a href="{{ route('register') }}" class="text-blue-500 font-semibold hover:text-blue-600 hover:underline transition-colors duration-300">
                    Register disini!
                </a>
            </p>
        </div> --}}
    </div>

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
            animation: fadeIn 0.5s ease-out;
        }

        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</body>
</html>
