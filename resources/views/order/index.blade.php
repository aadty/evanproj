@extends('layouts.main')

@section('title', 'Order Management')

@section('content')
    <div class="p-6 ml-12 md:p-8 md:ml-0">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-6xl md:text-4xl font-bold text-gray-900 text-center animate-fade-in">Order</h1>
        </div>

        <!-- Info and Action Bar -->
        <div class="flex gap-4 mb-8">
            <!-- Left Column: Date and Search -->
            <div class="flex flex-col gap-2 flex-1">
                <!-- Date Display -->
                <div class="text-black">
                    <p class="text-sm md:text-base" id="currentDate">Loading...</p>
                </div>

                <!-- Search and Date Filter Row -->
                <div class="flex gap-3 items-center flex-1">
                    <!-- Search Filter -->
                    <input type="text" id="searchInput" placeholder="Search..."
                        class="w-1/2 px-4 py-2 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-gray-400"
                        onkeyup="filterOrders()">
                    
                    <!-- Date Filter -->
                    <input type="date" id="dateFilter"
                        class="w-1/2 px-4 py-2 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        onchange="filterByDate()">
                </div>
            </div>

            <!-- Right Column: Add Button (Full Height) -->
            <div class="flex flex-col w-1/3 items-center justify-center">
                <button onclick="openModal()" 
                    class="w-full h-2/3 px-4 bg-white text-green-700 font-semibold rounded-lg hover:bg-green-50 transition-all duration-300 flex items-center justify-center group"
                    title="Add New Order" aria-label="Add Order">
                    <span class="w-full h-8 pb-1 bg-green-500 rounded-md flex items-center justify-center text-white text-2xl leading-none shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                        +
                    </span>
                </button>
            </div>

        </div>

    

    <!-- Plat Tipis Table -->
    <div class="mb-14 animate-fade-in">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Plat Tipis</h2>
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody id="platTipisTable">
                    @forelse($orders['plat-tipis'] ?? [] as $order)
                        @if ($order->status === 'pending')
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row"
                                data-order-id="{{ $order->id }}" data-no="{{ $order->no }}"
                                data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}"
                                data-barang="{{ $order->barang }}"
                                data-created-at="{{ $order->created_at->format('Y-m-d H:i:s') }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3 items-center">
                                        <button onclick="showDetail({{ $order->id }}, '{{ $order->no }}', '{{ $order->nama }}', '{{ $order->barang }}', '{{ $order->created_at->format('d/m/Y') }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 hover:bg-blue-200 transition-colors"
                                            title="Detail">
                                            <img src="{{ asset('images/detail-icon.png') }}" alt="Detail" class="w-4 h-4">
                                        </button>
                                        <button onclick="deleteOrder({{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 transition-colors"
                                            title="Delete">
                                            <img src="{{ asset('images/delete-icon.png') }}" alt="Delete" class="w-4 h-4">
                                        </button>
                                        <button
                                            onclick="editOrder({{ $order->id }}, 'plat-tipis', '{{ $order->nama }}', '{{ $order->barang }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 hover:bg-yellow-200 transition-colors"
                                            title="Edit">
                                            <img src="{{ asset('images/edit-icon.png') }}" alt="Edit" class="w-4 h-4">
                                        </button>
                                        <button onclick="completeOrder({{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 hover:bg-green-200 transition-colors"
                                            title="Complete">
                                            <img src="{{ asset('images/checklis.png') }}" alt="Complete" class="w-4 h-4">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">No orders yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Plat Tebal Table -->
    <div class="mb-14 animate-fade-in">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Plat Tebal</h2>
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody id="platTebalTable">
                    @forelse($orders['plat-tebal'] ?? [] as $order)
                        @if ($order->status === 'pending')
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row"
                                data-order-id="{{ $order->id }}" data-no="{{ $order->no }}"
                                data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}"
                                data-barang="{{ $order->barang }}"
                                data-created-at="{{ $order->created_at->format('Y-m-d H:i:s') }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3 items-center">
                                        <button onclick="showDetail({{ $order->id }}, '{{ $order->no }}', '{{ $order->nama }}', '{{ $order->barang }}', '{{ $order->created_at->format('d/m/Y') }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 hover:bg-blue-200 transition-colors"
                                            title="Detail">
                                            <img src="{{ asset('images/detail-icon.png') }}" alt="Detail" class="w-4 h-4">
                                        </button>
                                        <button onclick="deleteOrder({{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 transition-colors"
                                            title="Delete">
                                            <img src="{{ asset('images/delete-icon.png') }}" alt="Delete" class="w-4 h-4">
                                        </button>
                                        <button
                                            onclick="editOrder({{ $order->id }}, 'plat-tebal', '{{ $order->nama }}', '{{ $order->barang }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 hover:bg-yellow-200 transition-colors"
                                            title="Edit">
                                            <img src="{{ asset('images/edit-icon.png') }}" alt="Edit" class="w-4 h-4">
                                        </button>
                                        <button onclick="completeOrder({{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 hover:bg-green-200 transition-colors"
                                            title="Complete">
                                            <img src="{{ asset('images/checklis.png') }}" alt="Complete" class="w-4 h-4">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">No orders yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pipa Table -->
    <div class="mb-8 animate-fade-in">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Pipa</h2>
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pipaTable">
                    @forelse($orders['pipa'] ?? [] as $order)
                        @if ($order->status === 'pending')
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row"
                                data-order-id="{{ $order->id }}" data-no="{{ $order->no }}"
                                data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}"
                                data-barang="{{ $order->barang }}"
                                data-created-at="{{ $order->created_at->format('Y-m-d H:i:s') }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3 items-center">
                                        <button onclick="showDetail({{ $order->id }}, '{{ $order->no }}', '{{ $order->nama }}', '{{ $order->barang }}', '{{ $order->created_at->format('d/m/Y') }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 hover:bg-blue-200 transition-colors"
                                            title="Detail">
                                            <img src="{{ asset('images/detail-icon.png') }}" alt="Detail" class="w-4 h-4">
                                        </button>
                                        <button onclick="deleteOrder({{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 transition-colors"
                                            title="Delete">
                                            <img src="{{ asset('images/delete-icon.png') }}" alt="Delete" class="w-4 h-4">
                                        </button>
                                        <button
                                            onclick="editOrder({{ $order->id }}, 'pipa', '{{ $order->nama }}', '{{ $order->barang }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 hover:bg-yellow-200 transition-colors"
                                            title="Edit">
                                            <img src="{{ asset('images/edit-icon.png') }}" alt="Edit" class="w-4 h-4">
                                        </button>
                                        <button onclick="completeOrder({{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 hover:bg-green-200 transition-colors"
                                            title="Complete">
                                            <img src="{{ asset('images/checklis.png') }}" alt="Complete" class="w-4 h-4">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500">No orders yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Order Details</h2>
                <button onclick="closeDetail()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="overflow-x-auto bg-gray-50 rounded-lg border border-gray-200">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100 border-b border-gray-200">
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Barang</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 hover:bg-white transition-colors">
                                <td class="px-4 py-3 text-gray-900" id="detailNo">-</td>
                                <td class="px-4 py-3 text-gray-900" id="detailNama">-</td>
                                <td class="px-4 py-3 text-gray-900" id="detailBarang">-</td>
                                <td class="px-4 py-3 text-gray-600" id="detailTime">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-200 px-6 py-4 flex justify-end">
                <button onclick="closeDetail()" class="px-6 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="orderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white/75 rounded-lg shadow-lg w-full max-w-md">
            <!-- Modal Header -->
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 id="modalTitle" class="text-xl font-bold text-gray-900">Add Order</h2>
            </div>

            <!-- Modal Body -->
            <form id="orderForm" class="p-6 space-y-4">
                @csrf
                <input type="hidden" id="orderId">
                <input type="hidden" id="_method">

                    <!-- No (Auto-filled, Read-only) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">No</label>
                    <input type="text" id="noField" readonly
                        class="w-full px-4 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 cursor-not-allowed transition-colors duration-300">
                </div>

                <!-- Kode (Auto-filled, Read-only) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode</label>
                    <input type="text" id="kodeField" readonly
                        class="w-full px-4 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 cursor-not-allowed transition-colors duration-300">
                </div>

                <!-- Kategori Dropdown -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select id="kategoriField"
                        class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        onchange="updateKode()">
                        <option value="">Pilih Kategori</option>
                        <option value="plat-tipis">Plat Tipis</option>
                        <option value="plat-tebal">Plat Tebal</option>
                        <option value="pipa">Pipa</option>
                    </select>
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                    <input type="text" id="namaField"
                        class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        placeholder="Masukkan nama konsumen">
                </div>

                <!-- Barang -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-semibold text-gray-700">Barang</label>
                        <button type="button" onclick="addBarangRow()"
                            class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition-colors font-semibold text-sm"
                            title="Tambah barang">
                            +
                        </button>
                    </div>
                    <div id="barangContainer" class="space-y-2">
                        <!-- Barang rows will be added here -->
                    </div>
                </div>

                <!-- Error Message -->
                <div id="errorMessage"
                    class="hidden px-4 py-3 bg-red-50 border-2 border-red-200 rounded-lg text-red-700 text-sm font-medium animate-shake"></div>

                <!-- Modal Footer -->
                <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 px-4 py-2 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-100 transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 active:scale-95 transition-all duration-300 shadow-md hover:shadow-lg">
                        Submit
                    </button>
                </div>
            </form>
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
        function showDetail(id, no, nama, barang, time) {
            document.getElementById('detailNo').innerText = no;
            document.getElementById('detailNama').innerText = nama;
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

        // Add barang row
        function addBarangRow(barangValue = '', pcsValue = '1') {
            const container = document.getElementById('barangContainer');
            const rowId = 'barang-' + Date.now();
            
            const row = document.createElement('div');
            row.className = 'barang-row flex gap-2';
            row.id = rowId;
            
            row.innerHTML = `
                <input type="text" class="barang-input flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" placeholder="Masukkan detail barang" value="${barangValue}">
                <div class="relative flex-1 max-w-xs">
                    <input type="text" class="pcs-input w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" placeholder="Jumlah" value="${pcsValue}">
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold pointer-events-none">pcs</span>
                </div>
                <button type="button" onclick="removeBarangRow('${rowId}')" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-colors font-semibold" title="Hapus barang">
                    −
                </button>
            `;
            
            container.appendChild(row);
        }

        // Remove barang row
        function removeBarangRow(rowId) {
            const row = document.getElementById(rowId);
            if (row) {
                row.style.animation = 'slideOut 0.3s ease-in-out';
                setTimeout(() => row.remove(), 300);
            }
        }

        // Open modal for adding new order
        function openModal() {
            const modal = document.getElementById('orderModal');
            document.getElementById('orderForm').reset();
            document.getElementById('orderId').value = '';
            document.getElementById('_method').value = '';
            document.getElementById('modalTitle').innerText = 'Add Order';
            document.getElementById('errorMessage').classList.add('hidden');
            
            // Initialize barang container with one empty row
            const barangContainer = document.getElementById('barangContainer');
            barangContainer.innerHTML = '';
            addBarangRow();
            
            generateNextNo();
            modal.classList.remove('hidden');
            modal.style.animation = 'fadeIn 0.3s ease-in-out';
            document.body.style.overflow = 'hidden';
        }

        // Close modal
        function closeModal() {
            const modal = document.getElementById('orderModal');
            modal.classList.add('hidden');
            document.getElementById('orderForm').reset();
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
                    const rowDate = createdAtAttr.split(' ')[0]; // Get only the date part YYYY-MM-DD
                    const matches = rowDate === selectedDate;
                    row.style.display = matches ? '' : 'none';
                    row.style.animation = matches ? 'fadeIn 0.3s ease-in-out' : '';
                }
            });
        }

        function generateNextNo() {
            fetch('{{ route('order.index') }}')
                .then(response => response.text())
                .then(html => {
                    const orders = document.querySelectorAll('[data-order-id]');
                    const lastNo = Array.from(orders).map(row => {
                        const cell = row.querySelector('td');
                        return parseInt(cell?.innerText || 0);
                    }).reduce((max, num) => Math.max(max, num), 0);

                    const nextNo = String(lastNo + 1).padStart(4, '0');
                    document.getElementById('noField').value = nextNo;
                    updateKode();
                })
                .catch(error => console.error('Error generating next number:', error));
        }

        // Update kode based on kategori
        function updateKode() {
            const no = document.getElementById('noField').value;
            const kategori = document.getElementById('kategoriField').value;

            const prefixMap = {
                'plat-tipis': 'pt',
                'plat-tebal': 'pb',
                'pipa': 'p'
            };

            const prefix = prefixMap[kategori] || '';
            document.getElementById('kodeField').value = prefix ? `${prefix}-${no}` : '';
        }

        // Edit order
        function editOrder(id, kategori, nama, barang) {
            document.getElementById('orderId').value = id;
            document.getElementById('_method').value = 'PUT';
            document.getElementById('modalTitle').innerText = 'Edit Order';
            document.getElementById('kategoriField').value = kategori;
            document.getElementById('namaField').value = nama;
            document.getElementById('errorMessage').classList.add('hidden');

            // Clear and populate barang container
            const barangContainer = document.getElementById('barangContainer');
            barangContainer.innerHTML = '';
            
            // Parse existing barang string (format: "barang1 (pcs1), barang2 (pcs2)")
            const barangItems = barang.split(',').map(item => item.trim());
            barangItems.forEach(item => {
                const match = item.match(/^(.+?)\s*\((\d+)\)$/);
                if (match) {
                    addBarangRow(match[1], match[2]);
                } else {
                    addBarangRow(item, '1');
                }
            });

            const row = document.querySelector(`[data-order-id="${id}"]`);
            if (row) {
                const cells = row.querySelectorAll('td');
                if (cells.length > 0) {
                    document.getElementById('noField').value = cells[0].innerText;
                    updateKode();
                }
            }

            const modal = document.getElementById('orderModal');
            modal.classList.remove('hidden');
            modal.style.animation = 'fadeIn 0.3s ease-in-out';
            document.body.style.overflow = 'hidden';
        }

        // Submit form (add or update)
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const orderId = document.getElementById('orderId').value;
            const kategori = document.getElementById('kategoriField').value;
            const nama = document.getElementById('namaField').value.trim();
            const errorMsg = document.getElementById('errorMessage');

            // Collect all barang entries
            const barangRows = document.querySelectorAll('.barang-row');
            const barangList = [];
            
            barangRows.forEach(row => {
                const barangInput = row.querySelector('.barang-input');
                const pcsInput = row.querySelector('.pcs-input');
                if (barangInput.value.trim()) {
                    barangList.push({
                        barang: barangInput.value.trim(),
                        pcs: pcsInput.value.trim() || '1'
                    });
                }
            });

            // Validation
            if (!kategori) {
                showError(errorMsg, 'Pilih kategori terlebih dahulu');
                return;
            }
            if (!nama) {
                showError(errorMsg, 'Nama konsumen tidak boleh kosong');
                return;
            }
            if (barangList.length === 0) {
                showError(errorMsg, 'Tambahkan minimal satu barang');
                return;
            }

            const url = orderId ? `/order/${orderId}` : '/order';
            const method = orderId ? 'PUT' : 'POST';

            // Convert barangList to string format for database storage
            const barangString = barangList.map(b => `${b.barang} (${b.pcs})`).join(', ');

            const data = {
                _token: document.querySelector('input[name="_token"]').value,
                kategori,
                nama,
                barang: barangString,
            };

            // Disable submit button during request
            const submitBtn = document.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;
            submitBtn.disabled = true;
            submitBtn.innerText = 'Loading...';

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        closeModal();
                        location.reload();
                    } else {
                        showError(errorMsg, data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError(errorMsg, 'Terjadi kesalahan jaringan. Silakan coba lagi.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerText = originalText;
                });
        });

        // Delete order with confirmation
        function deleteOrder(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus order ini?')) return;

            const button = event.target.closest('button');
            button.disabled = true;
            button.style.opacity = '0.5';

            fetch(`/order/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`[data-order-id="${id}"]`);
                        if (row) {
                            row.style.animation = 'slideOut 0.3s ease-in-out';
                            setTimeout(() => row.remove(), 300);
                        }
                    } else {
                        showErrorAlert(data.message || 'Gagal menghapus order');
                        button.disabled = false;
                        button.style.opacity = '1';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert('Terjadi kesalahan jaringan');
                    button.disabled = false;
                    button.style.opacity = '1';
                });
        }

        // Complete order
        function completeOrder(id) {
            const button = event.target.closest('button');
            button.disabled = true;
            button.style.opacity = '0.5';

            fetch(`/order/${id}/complete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        _token: document.querySelector('input[name="_token"]').value,
                    }),
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`[data-order-id="${id}"]`);
                        if (row) {
                            row.style.animation = 'slideOut 0.3s ease-in-out';
                            setTimeout(() => row.remove(), 300);
                        }
                    } else {
                        showErrorAlert(data.message || 'Gagal menyelesaikan order');
                        button.disabled = false;
                        button.style.opacity = '1';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert('Terjadi kesalahan jaringan');
                    button.disabled = false;
                    button.style.opacity = '1';
                });
        }

        // Helper function to show error in modal
        function showError(element, message) {
            element.innerText = message;
            element.classList.remove('hidden');
            element.style.animation = 'shake 0.5s ease-in-out';
            setTimeout(() => {
                element.style.animation = '';
            }, 500);
        }

        // Helper function to show error alert
        function showErrorAlert(message) {
            alert(message);
        }

        // Close modal when clicking outside
        document.getElementById('orderModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

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
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(100%); }
            }
            
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
            
            .animate-fade-in {
                animation: fadeIn 0.6s ease-in-out;
            }
            
            .animate-shake {
                animation: shake 0.5s ease-in-out;
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
