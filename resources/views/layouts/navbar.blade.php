<!-- Sidebar Navigation Component -->
<nav
    class="fixed left-0 top-16 h-[calc(100vh-64px)] w-[60px] bg-gray-100 border-r border-gray-200 flex flex-col items-center py-3 space-y-3">
    <!-- Navigation Slot 1 - Orders -->
    <a
        href="{{ route('order.index') }}"
        class="nav-link w-10 h-10 rounded-lg bg-[#A2B8CC] shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center focus:outline-none"
        data-route="order.index"
        title="Orders">
        <img src="{{ asset('images/order2.png') }}" alt="Orders" class="w-6 h-6 object-contain">
    </a>

    <!-- Navigation Slot 2 - Order Completed -->
    <a
        href="{{ route('order.completed') }}"
        class="nav-link w-10 h-10 rounded-lg bg-[#A2B8CC] shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center focus:outline-none"
        data-route="order.completed"
        title="Order Completed">
        <img src="{{ asset('images/order-c.png') }}" alt="Order Completed" class="w-6 h-6 object-contain">
    </a>

    <!-- Navigation Slot 3 - Taken -->
    <a
        href="{{ route('order.taken') }}"
        class="nav-link w-10 h-10 rounded-lg bg-[#A2B8CC] shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center focus:outline-none"
        data-route="order.taken"
        title="Taken">
        <img src="{{ asset('images/hf.png') }}" alt="Taken" class="w-6 h-6 object-contain">
    </a>

    <!-- Navigation Slot 4 - Delivery -->
    <a
        href="{{ route('order.delivery') }}"
        class="nav-link w-10 h-10 rounded-lg bg-[#A2B8CC] shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center focus:outline-none"
        data-route="order.delivery"
        title="Delivery">
        <img src="{{ asset('images/deliv.png') }}" alt="Delivery" class="w-6 h-6 object-contain">
    </a>

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

<script>
    // Set active navbar link based on current route
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            const route = link.getAttribute('data-route');

            // Check if the current href matches (exact path matching)
            const isActive = currentPath === new URL(href, window.location.origin).pathname;

            if (isActive) {
                // Active state: white background
                link.classList.remove('bg-[#A2B8CC]');
                link.classList.add('bg-white');
                link.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            } else {
                // Inactive state: reset to default
                link.classList.remove('bg-white');
                link.classList.add('bg-[#A2B8CC]');
                link.style.boxShadow = '';
            }
        });
    });
</script>
