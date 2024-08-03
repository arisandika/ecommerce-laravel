<aside class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="waves-effect">
                        <i class="bx bxs-dashboard"></i>
                        <span>Dashboards</span>
                    </a>
                </li>
                <li class="menu-title">Apps</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-store"></i>
                        <span>Ecommerce</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.products.index') }}" wire:navigate>Products</a></li>
                        <li><a href="{{ route('admin.products.add') }}" wire:navigate>Add Products</a></li>
                        <li><a href="{{ route('admin.size.index') }}" wire:navigate>Product Sizes</a></li>
                        <li><a href="{{ route('admin.categories.index') }}" wire:navigate>Categories</a></li>
                        <li><a href="{{ route('admin.orders.index') }}" wire:navigate>Orders</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-receipt"></i>
                        <span>Invoices</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="invoices-list.html">Invoice List</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span>User</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="contacts-grid.html">Users List</a></li>
                    </ul>
                </li>
                <li class="menu-title">Pages</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home"></i>
                        <span>Home Page</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.sliders.index') }}" wire:navigate>Sliders</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-detail"></i>
                        <span>Blog</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="blog-list.html">Blog List</a></li>
                        <li><a href="blog-grid.html">Blog Post</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-file"></i>
                        <span>Utility</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-maintenance.html">Maintenance</a></li>
                        <li><a href="pages-faqs.html">FAQs</a></li>
                        <li><a href="pages-pricing.html">Pricing</a></li>
                        <li><a href="pages-404.html">Error 404</a></li>
                        <li><a href="pages-500.html">Error 500</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</aside>
