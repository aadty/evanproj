@extends('layouts.main')

@section('title', 'Order Completed')

@section('content')
<div class="p-6 ml-12 md:p-8 md:ml-0">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Order Completed</h1>
    </div>

    <!-- Info and Action Bar -->
    <div class="flex gap-4 mb-8">
        <!-- Left Column: Date and Search -->
        <div class="flex flex-col gap-3 flex-1">
            <!-- Date Display -->
            <div class="text-gray-600">
                <p class="text-sm md:text-base" id="currentDate">Loading...</p>
            </div>

            <!-- Search and Date Filter Row -->
            <div class="flex gap-3 items-center flex-wrap">
                <!-- Search Filter -->
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Search..." 
                    class="flex-1 min-w-[150px] px-4 py-2 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    onkeyup="filterOrders()"
                >
                
                <!-- Date Filter -->
                <input type="date" id="dateFilter"
                    class="px-4 py-2 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    onchange="filterByDate()">
            </div>
        </div>
    </div>

    <!-- Plat Tipis Table -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Plat Tipis</h2>
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Barang</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Time</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody id="platTipisTable">
                    @forelse($orders['plat-tipis'] ?? [] as $order)
                        @if($order->status === 'complete')
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row" data-order-id="{{ $order->id }}" data-no="{{ $order->no }}" data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}" data-created-at="{{ $order->created_at->format('Y-m-d H:i:s') }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->nama }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->barang }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3 items-center">
                                        <button onclick="deleteOrder({{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 transition-colors"
                                            title="Delete">
                                            <img src="{{ asset('images/delete-icon.png') }}" alt="Delete" class="w-4 h-4">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">No completed orders yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Plat Tebal Table -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Plat Tebal</h2>
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Barang</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Time</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody id="platTebalTable">
                    @forelse($orders['plat-tebal'] ?? [] as $order)
                        @if($order->status === 'complete')
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row" data-order-id="{{ $order->id }}" data-no="{{ $order->no }}" data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}" data-created-at="{{ $order->created_at->format('Y-m-d H:i:s') }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->nama }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->barang }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3 items-center">
                                        <button onclick="deleteOrder({{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 transition-colors"
                                            title="Delete">
                                            <img src="{{ asset('images/delete-icon.png') }}" alt="Delete" class="w-4 h-4">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">No completed orders yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pipa Table -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Pipa</h2>
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Barang</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Time</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pipaTable">
                    @forelse($orders['pipa'] ?? [] as $order)
                        @if($order->status === 'complete')
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row" data-order-id="{{ $order->id }}" data-no="{{ $order->no }}" data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}" data-created-at="{{ $order->created_at->format('Y-m-d H:i:s') }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->nama }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->barang }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3 items-center">
                                        <button onclick="deleteOrder({{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 transition-colors"
                                            title="Delete">
                                            <img src="{{ asset('images/delete-icon.png') }}" alt="Delete" class="w-4 h-4">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">No completed orders yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Set current date
    document.addEventListener('DOMContentLoaded', function() {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const today = new Date();
        const formatter = new Intl.DateTimeFormat('id-ID', options);
        document.getElementById('currentDate').innerText = formatter.format(today);
    });

    // Filter orders by no, kode, or nama
    function filterOrders() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.order-row');

        rows.forEach(row => {
            const no = row.getAttribute('data-no') || '';
            const kode = row.getAttribute('data-kode') || '';
            const nama = row.getAttribute('data-nama') || '';

            if (no.toLowerCase().includes(searchValue) || 
                kode.toLowerCase().includes(searchValue) || 
                nama.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Filter orders by date
    function filterByDate() {
        const selectedDate = document.getElementById('dateFilter').value;
        const rows = document.querySelectorAll('.order-row');

        rows.forEach(row => {
            if (!selectedDate) {
                row.style.display = '';
                return;
            }

            const createdAtAttr = row.getAttribute('data-created-at');
            
            if (createdAtAttr) {
                const rowDate = createdAtAttr.split(' ')[0]; // Get only the date part YYYY-MM-DD
                const matches = rowDate === selectedDate;
                row.style.display = matches ? '' : 'none';
            }
        });
    }

    // Delete order
    function deleteOrder(id) {
        if (!confirm('Are you sure you want to delete this order?')) return;
        
        fetch(`/order/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        });
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        // Handle outside clicks if needed
    });
</script>
@endsection
