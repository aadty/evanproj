<!-- Header Component -->
<header class="h-16 bg-linear-to-r from-[#A2B8CC] to-[#DADADA]/25 flex items-center justify-between px-6 fixed top-0 left-0 right-0 z-50 shadow-sm">
    <!-- Left Side (Brand/Logo) -->
    <div class="flex items-center">
        <h1 class="text-lg font-semibold text-gray-800"></h1>
    </div>

    <!-- Right Side (Dropdown Menu) -->
    <div class="relative">
        <!-- Icon Button -->
        <button 
            id="profileMenuBtn" 
            class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center hover:bg-gray-400 transition-colors duration-300 focus:outline-none"
            onclick="toggleProfileMenu()"
        >
            <!-- Placeholder Icon (User) -->
            <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div 
            id="profileMenu" 
            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg p-2 animate-fadeIn"
        >
            <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-200">
                <p class="font-semibold">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'user@example.com' }}</p>
            </div>
            
            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="p-0">
                @csrf
                <button 
                    type="submit" 
                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded transition-colors duration-300 font-semibold"
                >
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>

<script>
    function toggleProfileMenu() {
        const menu = document.getElementById('profileMenu');
        menu.classList.toggle('hidden');
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('profileMenu');
        const btn = document.getElementById('profileMenuBtn');
        if (!menu.contains(event.target) && !btn.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.2s ease-out;
    }
</style>
