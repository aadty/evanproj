@extends('layouts.main')

@section('title', 'Order Management')

@section('content')
<div class="p-6 ml-12 md:p-8 md:ml-0">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Order</h1>
    </div>

    <!-- Info and Action Bar -->
    <div class="flex flex-col gap-4 mb-8">
        <!-- Date Display -->
        <div class="text-gray-600">
            <p class="text-sm md:text-base" id="currentDate">Loading...</p>
        </div>

        <!-- Add Button -->
        <button 
            onclick="openModal()" 
            class="w-full md:w-auto px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors duration-300"
        >
            Add
        </button>

        <!-- Search Filter -->
        <input 
            type="text" 
            id="searchInput" 
            placeholder="Search by No, Kode, or Nama..." 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            onkeyup="filterOrders()"
        >

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
                        @if($order->status === 'pending')
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row" data-order-id="{{ $order->id }}" data-no="{{ $order->no }}" data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->nama }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->barang }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <button onclick="deleteOrder({{ $order->id }})" class="px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition-colors">Delete</button>
                                        <button onclick="editOrder({{ $order->id }}, 'plat-tipis', '{{ $order->nama }}', '{{ $order->barang }}')" class="px-2 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600 transition-colors">Edit</button>
                                        <button onclick="completeOrder({{ $order->id }})" class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition-colors">Complete</button>
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
                        @if($order->status === 'pending')
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row" data-order-id="{{ $order->id }}" data-no="{{ $order->no }}" data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->nama }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->barang }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <button onclick="deleteOrder({{ $order->id }})" class="px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition-colors">Delete</button>
                                        <button onclick="editOrder({{ $order->id }}, 'plat-tebal', '{{ $order->nama }}', '{{ $order->barang }}')" class="px-2 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600 transition-colors">Edit</button>
                                        <button onclick="completeOrder({{ $order->id }})" class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition-colors">Complete</button>
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
                        @if($order->status === 'pending')
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors order-row" data-order-id="{{ $order->id }}" data-no="{{ $order->no }}" data-kode="{{ $order->kode }}" data-nama="{{ strtolower($order->nama) }}">
                                <td class="px-4 py-3 text-gray-900">{{ $order->no }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->kode }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->nama }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $order->barang }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <button onclick="deleteOrder({{ $order->id }})" class="px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition-colors">Delete</button>
                                        <button onclick="editOrder({{ $order->id }}, 'pipa', '{{ $order->nama }}', '{{ $order->barang }}')" class="px-2 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600 transition-colors">Edit</button>
                                        <button onclick="completeOrder({{ $order->id }})" class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition-colors">Complete</button>
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
</div>

<!-- Modal -->
<div id="orderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
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
                <input 
                    type="text" 
                    id="noField" 
                    readonly 
                    class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed"
                >
            </div>

            <!-- Kode (Auto-filled, Read-only) -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kode</label>
                <input 
                    type="text" 
                    id="kodeField" 
                    readonly 
                    class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed"
                >
            </div>

            <!-- Kategori Dropdown -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                <select 
                    id="kategoriField" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onchange="updateKode()"
                >
                    <option value="">Pilih Kategori</option>
                    <option value="plat-tipis">Plat Tipis</option>
                    <option value="plat-tebal">Plat Tebal</option>
                    <option value="pipa">Pipa</option>
                </select>
            </div>

            <!-- Nama -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                <input 
                    type="text" 
                    id="namaField" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter product name"
                >
            </div>

            <!-- Barang -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Barang</label>
                <input 
                    type="text" 
                    id="barangField" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter item details"
                >
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="hidden px-4 py-2 bg-red-50 border border-red-200 rounded text-red-700 text-sm"></div>

            <!-- Modal Footer -->
            <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="closeModal()" 
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="flex-1 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors"
                >
                    Submit
                </button>
            </div>
        </form>
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

    // Open modal for adding new order
    function openModal() {
        document.getElementById('orderForm').reset();
        document.getElementById('orderId').value = '';
        document.getElementById('_method').value = '';
        document.getElementById('modalTitle').innerText = 'Add Order';
        document.getElementById('errorMessage').classList.add('hidden');
        generateNextNo();
        document.getElementById('orderModal').classList.remove('hidden');
    }

    // Close modal
    function closeModal() {
        document.getElementById('orderModal').classList.add('hidden');
        document.getElementById('orderForm').reset();
    }

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
    function generateNextNo() {
        fetch('{{ route("order.index") }}')
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
            });
    }

    // Update kode based on kategori
    function updateKode() {
        const no = document.getElementById('noField').value;
        const kategori = document.getElementById('kategoriField').value;
        
        let prefix = '';
        switch(kategori) {
            case 'plat-tipis':
                prefix = 'pt';
                break;
            case 'plat-tebal':
                prefix = 'pb';
                break;
            case 'pipa':
                prefix = 'p';
                break;
        }
        
        document.getElementById('kodeField').value = prefix ? `${prefix}-${no}` : '';
    }

    // Edit order
    function editOrder(id, kategori, nama, barang) {
        document.getElementById('orderId').value = id;
        document.getElementById('_method').value = 'PUT';
        document.getElementById('modalTitle').innerText = 'Edit Order';
        document.getElementById('kategoriField').value = kategori;
        document.getElementById('namaField').value = nama;
        document.getElementById('barangField').value = barang;
        document.getElementById('errorMessage').classList.add('hidden');
        
        fetch(`/order/${id}`)
            .then(response => response.text())
            .then(html => {
                const noMatch = html.match(/data-order-id="(\d+)"/);
                if (noMatch) {
                    const rows = document.querySelectorAll(`[data-order-id="${id}"]`);
                    const row = rows[0];
                    if (row) {
                        const cells = row.querySelectorAll('td');
                        if (cells.length > 0) {
                            document.getElementById('noField').value = cells[0].innerText;
                            updateKode();
                        }
                    }
                }
            });
        
        document.getElementById('orderModal').classList.remove('hidden');
    }

    // Submit form (add or update)
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const orderId = document.getElementById('orderId').value;
        const kategori = document.getElementById('kategoriField').value;
        const nama = document.getElementById('namaField').value;
        const barang = document.getElementById('barangField').value;
        
        if (!kategori || !nama || !barang) {
            document.getElementById('errorMessage').innerText = 'All fields are required';
            document.getElementById('errorMessage').classList.remove('hidden');
            return;
        }
        
        const url = orderId ? `/order/${orderId}` : '/order';
        const method = orderId ? 'PUT' : 'POST';
        
        const data = {
            _token: document.querySelector('input[name="_token"]').value,
            kategori,
            nama,
            barang,
        };
        
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal();
                location.reload();
            } else {
                document.getElementById('errorMessage').innerText = data.message;
                document.getElementById('errorMessage').classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('errorMessage').innerText = 'An error occurred';
            document.getElementById('errorMessage').classList.remove('hidden');
        });
    });

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

    // Complete order
    function completeOrder(id) {
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
    document.getElementById('orderModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection
