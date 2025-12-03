@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 ml-12 md:p-8 md:ml-0">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">alow! 👋</h1>
        <p class="text-gray-600">{{ $user->name }} berhasil log in</p>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
            <span class="text-green-600 font-bold mr-2">✓</span>
            <span class="text-green-700 text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Grid Layout for Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- User Profile Card -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Profile</h2>
            
            <!-- Avatar -->
            <div class="mb-4 flex justify-center">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-2xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>

            <!-- User Details -->
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Name</p>
                    <p class="text-gray-900 font-semibold">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Email</p>
                    <p class="text-gray-900 font-semibold text-sm break-all">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Member Since</p>
                    <p class="text-gray-900 font-semibold">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Sample Card 1 -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Sample 1</h2>
            <p class="text-gray-600 text-sm mb-4">hanya untuk testing visualisasi.</p>
            <div class="h-24 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">Content Area</div>
        </div>

        <!-- Sample Card 2 -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Sample 2</h2>
            <p class="text-gray-600 text-sm mb-4">hanya untuk testing visualisasi.</p>
            <div class="h-24 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">Content Area</div>
        </div>
    </div>

    <!-- Wide Content Section -->
    <div class="mt-6 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Activity Overview</h2>
        <div class="h-32 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400 border border-dashed border-gray-300">
            Your activity data will display here
        </div>
    </div>
</div>
@endsection
