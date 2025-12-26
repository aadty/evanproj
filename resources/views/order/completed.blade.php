@extends('layouts.main')

@section('title', 'Order Completed')

@section('content')
<div class="p-6 ml-12 md:p-8 md:ml-0">
    <!-- Header Section -->
   <div class="mb-8">
            <h1 class="text-6xl md:text-4xl font-bold text-gray-900 text-center animate-fade-in">Order Completed</h1>
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
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
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
                                <td class="px-4 py-3">
                                    @if(!is_null($order->taken_at))
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-purple-100 text-purple-700 font-medium text-xs">Taken</span>
                                    @elseif(!is_null($order->delivery_at))
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-cyan-100 text-cyan-700 font-medium text-xs">Delivered</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-gray-100 text-gray-600 font-medium text-xs">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3 items-center">
                                        <button onclick="showDetail({{ $order->id }}, '{{ $order->no }}', '{{ $order->barang }}', '{{ $order->created_at->format('H:i') }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 hover:bg-blue-200 transition-colors"
                                            title="Detail">
                                            <img src="{{ asset('images/detail-icon.png') }}" alt="Detail" class="w-4 h-4">
                                        </button>
                                        @if(is_null($order->taken_at) && is_null($order->delivery_at))
                                        <button onclick="markAction('taken', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium text-xs transition-colors"
                                            title="Mark as Taken">
                                            Taken
                                        </button>
                                        <button onclick="markAction('delivery', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-cyan-100 hover:bg-cyan-200 text-cyan-700 font-medium text-xs transition-colors"
                                            title="Mark as Delivery">
                                            Delivery
                                        </button>
                                        @elseif(!is_null($order->taken_at) && is_null($order->delivery_at))
                                        <button onclick="markAction('delivery', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-cyan-100 hover:bg-cyan-200 text-cyan-700 font-medium text-xs transition-colors"
                                            title="Mark as Delivery">
                                            Delivery
                                        </button>
                                        @elseif(is_null($order->taken_at) && !is_null($order->delivery_at))
                                        <button onclick="markAction('taken', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium text-xs transition-colors"
                                            title="Mark as Taken">
                                            Taken
                                        </button>
                                        @endif
                                        <button onclick="confirmAction('delete', {{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 transition-colors"
                                            title="Delete">
                                            <img src="{{ asset('images/delete-icon.png') }}" alt="Delete" class="w-4 h-4">
                                        </button>
                                        <button onclick="confirmAction('edit', {{ $order->id }}, 'plat-tipis', '{{ $order->nama }}', '{{ $order->barang }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 hover:bg-yellow-200 transition-colors"
                                            title="Edit">
                                            <img src="{{ asset('images/edit-icon.png') }}" alt="Edit" class="w-4 h-4">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">No completed orders yet</td>
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
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
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
                                <td class="px-4 py-3">
                                    @if(!is_null($order->taken_at))
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-purple-100 text-purple-700 font-medium text-xs">Taken</span>
                                    @elseif(!is_null($order->delivery_at))
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-cyan-100 text-cyan-700 font-medium text-xs">Delivered</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-gray-100 text-gray-600 font-medium text-xs">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3 items-center">
                                        <button onclick="showDetail({{ $order->id }}, '{{ $order->no }}', '{{ $order->barang }}', '{{ $order->created_at->format('H:i') }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 hover:bg-blue-200 transition-colors"
                                            title="Detail">
                                            <img src="{{ asset('images/detail-icon.png') }}" alt="Detail" class="w-4 h-4">
                                        </button>
                                        @if(is_null($order->taken_at) && is_null($order->delivery_at))
                                        <button onclick="markAction('taken', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium text-xs transition-colors"
                                            title="Mark as Taken">
                                            Taken
                                        </button>
                                        <button onclick="markAction('delivery', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-cyan-100 hover:bg-cyan-200 text-cyan-700 font-medium text-xs transition-colors"
                                            title="Mark as Delivery">
                                            Delivery
                                        </button>
                                        @elseif(!is_null($order->taken_at) && is_null($order->delivery_at))
                                        <button onclick="markAction('delivery', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-cyan-100 hover:bg-cyan-200 text-cyan-700 font-medium text-xs transition-colors"
                                            title="Mark as Delivery">
                                            Delivery
                                        </button>
                                        @elseif(is_null($order->taken_at) && !is_null($order->delivery_at))
                                        <button onclick="markAction('taken', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium text-xs transition-colors"
                                            title="Mark as Taken">
                                            Taken
                                        </button>
                                        @endif
                                        <button onclick="confirmAction('delete', {{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 transition-colors"
                                            title="Delete">
                                            <img src="{{ asset('images/delete-icon.png') }}" alt="Delete" class="w-4 h-4">
                                        </button>
                                        <button onclick="confirmAction('edit', {{ $order->id }}, 'plat-tebal', '{{ $order->nama }}', '{{ $order->barang }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 hover:bg-yellow-200 transition-colors"
                                            title="Edit">
                                            <img src="{{ asset('images/edit-icon.png') }}" alt="Edit" class="w-4 h-4">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">No completed orders yet</td>
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
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
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
                                <td class="px-4 py-3">
                                    @if(!is_null($order->taken_at))
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-purple-100 text-purple-700 font-medium text-xs">Taken</span>
                                    @elseif(!is_null($order->delivery_at))
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-cyan-100 text-cyan-700 font-medium text-xs">Delivered</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-gray-100 text-gray-600 font-medium text-xs">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-3 items-center">
                                        <button onclick="showDetail({{ $order->id }}, '{{ $order->no }}', '{{ $order->barang }}', '{{ $order->created_at->format('H:i') }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 hover:bg-blue-200 transition-colors"
                                            title="Detail">
                                            <img src="{{ asset('images/detail-icon.png') }}" alt="Detail" class="w-4 h-4">
                                        </button>
                                        @if(is_null($order->taken_at) && is_null($order->delivery_at))
                                        <button onclick="markAction('taken', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium text-xs transition-colors"
                                            title="Mark as Taken">
                                            Taken
                                        </button>
                                        <button onclick="markAction('delivery', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-cyan-100 hover:bg-cyan-200 text-cyan-700 font-medium text-xs transition-colors"
                                            title="Mark as Delivery">
                                            Delivery
                                        </button>
                                        @elseif(!is_null($order->taken_at) && is_null($order->delivery_at))
                                        <button onclick="markAction('delivery', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-cyan-100 hover:bg-cyan-200 text-cyan-700 font-medium text-xs transition-colors"
                                            title="Mark as Delivery">
                                            Delivery
                                        </button>
                                        @elseif(is_null($order->taken_at) && !is_null($order->delivery_at))
                                        <button onclick="markAction('taken', {{ $order->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium text-xs transition-colors"
                                            title="Mark as Taken">
                                            Taken
                                        </button>
                                        @endif
                                        <button onclick="confirmAction('delete', {{ $order->id }})"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 transition-colors"
                                            title="Delete">
                                            <img src="{{ asset('images/delete-icon.png') }}" alt="Delete" class="w-4 h-4">
                                        </button>
                                        <button onclick="confirmAction('edit', {{ $order->id }}, 'pipa', '{{ $order->nama }}', '{{ $order->barang }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 hover:bg-yellow-200 transition-colors"
                                            title="Edit">
                                            <img src="{{ asset('images/edit-icon.png') }}" alt="Edit" class="w-4 h-4">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">No completed orders yet</td>
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
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 px-6 py-4 flex justify-end">
            <button onclick="closeDetail()" class="px-6 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Password Confirmation Modal -->
<div id="passwordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-sm">
        <!-- Modal Header -->
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-lg font-bold text-gray-900">Konfirmasi Password</h2>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Masukkan Password</label>
            <input type="password" id="passwordInput" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Password">
            <div id="passwordError" class="hidden mt-2 text-red-600 text-sm">Password salah!</div>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 px-6 py-4 flex justify-end gap-3">
            <button onclick="closePasswordModal()" class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition-colors">
                Batal
            </button>
            <button onclick="confirmPassword()" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="orderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white/75 rounded-lg shadow-lg w-full max-w-md">
        <!-- Modal Header -->
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 id="modalTitle" class="text-xl font-bold text-gray-900">Edit Order</h2>
        </div>

        <!-- Modal Body -->
        <form id="orderForm" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="orderId">
            <input type="hidden" id="_method" value="PUT">

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
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let pendingAction = null;

    // Set current date
    document.addEventListener('DOMContentLoaded', function() {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
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

    // Add barang row
    function addBarangRow(barangValue = '', pcsValue = '1') {
        const container = document.getElementById('barangContainer');
        const rowId = 'barang-' + Date.now();

        const row = document.createElement('div');
        row.className = 'barang-row flex gap-2';
        row.id = rowId;

        row.innerHTML = `
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-600 mb-1">Barang</label>
                <input type="text" class="barang-input w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" placeholder="Masukkan detail barang" value="${barangValue}">
            </div>
            <div class="flex-1 max-w-xs">
                <label class="block text-xs font-medium text-gray-600 mb-1">Pcs</label>
                <input type="text" class="pcs-input w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" placeholder="Jumlah" value="${pcsValue}">
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

    // Close modal
    function closeModal() {
        const modal = document.getElementById('orderModal');
        modal.classList.add('hidden');
        document.getElementById('orderForm').reset();
        document.body.style.overflow = 'auto';
    }

    // Confirm action with password
    function confirmAction(action, id, ...args) {
        pendingAction = { action, id, args };
        document.getElementById('passwordModal').classList.remove('hidden');
        document.getElementById('passwordInput').value = '';
        document.getElementById('passwordError').classList.add('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Close password modal
    function closePasswordModal() {
        document.getElementById('passwordModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        pendingAction = null;
    }

    // Confirm password
    function confirmPassword() {
        const password = document.getElementById('passwordInput').value;
        const errorEl = document.getElementById('passwordError');

        // Hardcoded password for demo; replace with actual verification
        if (password === 'evansapta77.') {
            closePasswordModal();
            executeAction();
        } else {
            errorEl.classList.remove('hidden');
        }
    }

    // Execute pending action
    function executeAction() {
        if (!pendingAction) return;

        const { action, id, args } = pendingAction;
        if (action === 'delete') {
            deleteOrder(id);
        } else if (action === 'edit') {
            editOrder(id, ...args);
        }
        pendingAction = null;
    }

    // Mark order as taken or delivered
    function markAction(type, id) {
        if (type === 'taken') {
            if (!confirm('Mark this order as taken?')) return;
            fetch(`/order/${id}/taken`, {
                method: 'POST',
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
        } else if (type === 'delivery') {
            if (!confirm('Mark this order as delivered?')) return;
            fetch(`/order/${id}/delivery`, {
                method: 'POST',
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

        if (selectedDate) {
            const date = new Date(selectedDate);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const formatter = new Intl.DateTimeFormat('id-ID', options);
            document.getElementById('currentDate').innerText = formatter.format(date);
        } else {
            const today = new Date();
            const formatter = new Intl.DateTimeFormat('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('currentDate').innerText = formatter.format(today);
        }

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

    // Submit form (update)
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

        const url = `/order/${orderId}`;
        const method = 'PUT';

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

    // Delete order
    function deleteOrder(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus order ini?')) return;

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

    // Helper function to show error in modal
    function showError(element, message) {
        element.innerText = message;
        element.classList.remove('hidden');
        element.style.animation = 'shake 0.5s ease-in-out';
        setTimeout(() => {
            element.style.animation = '';
        }, 500);
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

        #dateFilter {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-calendar' viewBox='0 0 16 16'%3E%3Cpath d='M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z'/%3E%3C/svg%3E") no-repeat right 10px center;
            background-size: 16px;
            padding-right: 30px;
            color: transparent;
            cursor: pointer;
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
