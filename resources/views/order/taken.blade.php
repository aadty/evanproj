@extends('layouts.main')

@section('title', 'Orders Taken')

@section('content')
<div class="p-6 ml-12 md:p-8 md:ml-0">
    <!-- Header Section -->
   <div class="mb-8">
            <h1 class="text-6xl md:text-4xl font-bold text-gray-900 text-center animate-fade-in">Orders Taken</h1>
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
                    </tr>
                </thead>
                <tbody id="platTipisTable">
                    @forelse($orders['plat-tipis'] ?? [] as $order)
                        @if($order->status === 'complete' && !is_null($order->taken_at) && is_null($order->delivery_at))
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row" data-order-id="{{ $order->id }}" data-no="{{ $order->no }}" data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}" data-created-at="{{ $order->created_at->format('Y-m-d H:i:s') }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->nama }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500">No taken orders yet</td>
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
                    </tr>
                </thead>
                <tbody id="platTebalTable">
                    @forelse($orders['plat-tebal'] ?? [] as $order)
                        @if($order->status === 'complete' && !is_null($order->taken_at) && is_null($order->delivery_at))
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row" data-order-id="{{ $order->id }}" data-no="{{ $order->no }}" data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}" data-created-at="{{ $order->created_at->format('Y-m-d H:i:s') }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->nama }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500">No taken orders yet</td>
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
                    </tr>
                </thead>
                <tbody id="pipaTable">
                    @forelse($orders['pipa'] ?? [] as $order)
                        @if($order->status === 'complete' && !is_null($order->taken_at) && is_null($order->delivery_at))
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row" data-order-id="{{ $order->id }}" data-no="{{ $order->no }}" data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}" data-created-at="{{ $order->created_at->format('Y-m-d H:i:s') }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->nama }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500">No taken orders yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Order Details</h2>
                <button onclick="closeDetail()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">×</button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Barang</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200 hover:bg-white transition-colors">
                            <td class="px-4 py-3 text-gray-900" id="detailNo">-</td>
                            <td class="px-4 py-3 text-gray-900" id="detailBarang">-</td>
                            <td class="px-4 py-3 text-gray-600" id="detailTime">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-200 px-6 py-4 flex justify-end">
                <button onclick="closeDetail()" class="px-6 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Set current date
        document.addEventListener('DOMContentLoaded', function() {
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const today = new Date();
            const formatter = new Intl.DateTimeFormat('id-ID', options);
            document.getElementById('currentDate').innerText = formatter.format(today);
        });

        // Show detail modal
        function showDetail(id, no, barang, time) {
            document.getElementById('detailNo').innerText = no;
            document.getElementById('detailBarang').innerText = barang;
            document.getElementById('detailTime').innerText = time;

            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            modal.style.animation = 'fadeIn 0.3s ease-in-out';
            document.body.style.overflow = 'hidden';
        }

        // Close detail modal
        function closeDetail() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Filter orders by no, kode, or nama with debouncing
        let filterTimeout;
        function filterOrders() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(() => {
                const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
                const rows = document.querySelectorAll('.order-row');
                let visibleCount = 0;

                rows.forEach(row => {
                    const no = row.getAttribute('data-no') || '';
                    const kode = row.getAttribute('data-kode') || '';
                    const nama = row.getAttribute('data-nama') || '';

                    const matches = no.toLowerCase().includes(searchValue) ||
                        kode.toLowerCase().includes(searchValue) ||
                        nama.includes(searchValue);

                    row.style.display = matches ? '' : 'none';
                    row.style.animation = matches ? 'fadeIn 0.3s ease-in-out' : '';
                    if (matches) visibleCount++;
                });
            }, 300);
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

                const timeCell = row.querySelector('td:nth-child(5)');
                const createdAtAttr = row.getAttribute('data-created-at');
                
                if (createdAtAttr) {
                    const rowDate = createdAtAttr.split(' ')[0];
                    const matches = rowDate === selectedDate;
                    row.style.display = matches ? '' : 'none';
                    row.style.animation = matches ? 'fadeIn 0.3s ease-in-out' : '';
                }
            });
        }

        // Close detail modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetail();
            }
        });

        // Add animations to styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @keyframes slideOut {
                from { transform: translateX(0); }
                to { transform: translateX(100%); }
            }

            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }

            .animate-fade-in {
                animation: fadeIn 0.5s ease-in-out;
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
