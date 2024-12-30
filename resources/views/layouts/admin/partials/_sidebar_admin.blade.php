<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @role('admin')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active text-primary' : '' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Admin Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/categories') ? 'active text-primary' : '' }}"
                href="{{ route('admin.categories.index') }}">
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                <span class="menu-title">Category</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/sliders') ? 'active text-primary' : '' }}" href="{{ route('admin.sliders.index') }}">
                <i class="mdi mdi-image-filter-none menu-icon"></i>
                <span class="menu-title">Sliders</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/books') ? 'active text-primary' : '' }}" href="{{ route('admin.books.index') }}">
                <i class="mdi mdi-image-filter-none menu-icon"></i>
                <span class="menu-title">Books</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/transactions') ? 'active text-primary' : '' }}"
                href="{{ route('admin.transactions.index') }}">
                <i class="mdi mdi-cart menu-icon"></i>
                <span class="menu-title">Transactions</span>
            </a>
        </li>
        @endrole


        
        @role('customer')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('customers/dashboard') ? 'active text-primary' : '' }}"
                href="{{ route('customers.dashboard') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard Customer</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('customers/transactions') ? 'active text-primary' : '' }}"
                href="{{ route('customers.transactions.index') }}">
                <i class="mdi mdi-cart menu-icon"></i>
                <span class="menu-title">Transactions</span>
            </a>
        </li>
        @endrole
    </ul>
</nav>