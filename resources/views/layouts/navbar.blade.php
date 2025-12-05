<!-- Sidebar Navigation Component -->
<nav
    class="fixed left-0 top-16 h-[calc(100vh-64px)] w-[60px] bg-gray-100 border-r border-gray-200 flex flex-col items-center py-4 space-y-4">
    <!-- Navigation Slot 1 - Orders -->
    <a
        href="{{ route('order.index') }}"
        class="w-10 h-10 rounded-lg bg-[#A2B8CC] shadow-sm hover:shadow-md hover:bg-gray-50 transition-all duration-300 flex items-center justify-center focus:outline-none"
        title="Orders">
        <img src="{{ asset('images/order.png') }}" alt="Orders" class="w-6 h-6 object-contain">
    </a>

    <!-- Navigation Slot 2 - Order Completed -->
    <a
        href="{{ route('order.completed') }}"
        class="w-10 h-10 rounded-lg bg-[#A2B8CC] shadow-sm hover:shadow-md hover:bg-gray-50 transition-all duration-300 flex items-center justify-center focus:outline-none"
        title="Order Completed">
        <img src="{{ asset('images/order-c.png') }}" alt="Order Completed" class="w-6 h-6 object-contain">
    </a>

    <!-- Navigation Slot 3 - Help & FAQ -->
    <button
        class="w-10 h-10 rounded-lg bg-[#A2B8CC] shadow-sm hover:shadow-md hover:bg-gray-50 transition-all duration-300 flex items-center justify-center focus:outline-none"
        title="Help & FAQ">
        <img src="{{ asset('images/hf.png') }}" alt="Help & FAQ" class="w-6 h-6 object-contain">
    </button>

    <!-- Navigation Slot 4 - Delivery -->
    <button
        class="w-10 h-10 rounded-lg bg-[#A2B8CC] shadow-sm hover:shadow-md hover:bg-gray-50 transition-all duration-300 flex items-center justify-center focus:outline-none"
        title="Delivery">
        <img src="{{ asset('images/deliv.png') }}" alt="Delivery" class="w-6 h-6 object-contain">
    </button>

    <!-- Navigation Slot 5 - Reports -->
    <button
        class="w-10 h-10 rounded-lg bg-[#A2B8CC] shadow-sm hover:shadow-md hover:bg-gray-50 transition-all duration-300 flex items-center justify-center focus:outline-none"
        title="Reports">
        <img src="{{ asset('images/report.png') }}" alt="Reports" class="w-6 h-6 object-contain">
    </button>

    <!-- Navigation Slot 6 - Warehouse -->
    <button
        class="w-10 h-10 rounded-lg bg-[#A2B8CC] shadow-sm hover:shadow-md hover:bg-gray-50 transition-all duration-300 flex items-center justify-center focus:outline-none"
        title="Warehouse">
        <img src="{{ asset('images/warehouse 1.png') }}" alt="Warehouse" class="w-6 h-6 object-contain">
    </button>
</nav>
