<div class="header-mobile header_sticky">
    <div class="header-fullwidth d-flex align-items-center h-100">
        <a class="mobile-nav-activator d-block position-relative" href="#">
            <svg class="nav-icon" width="22" height="22" viewBox="0 0 25 18" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_nav" />
            </svg>
            <span class="btn-close-lg position-absolute top-0 start-0 w-100"></span>
        </a>
        <div class="logo">
            <a href="/">
                <img src="{{ asset('front/images/logo.jpg') }}" width="120" alt="Saintech"
                    class="logo__image d-block">
            </a>
        </div>
        <a href="/cart" class="header-tools__item header-tools__cart">
            <svg class="d-block" width="22" height="22" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_cart" />
            </svg>
            <livewire:front.cart.cart-count />
        </a>
    </div>
    <nav
        class="header-mobile__navigation navigation d-flex flex-column w-100 position-absolute top-100 bg-body overflow-auto">
        <div class="container">
            <form action="https://uomo-html.flexkitux.com/Demo9/search.html" method="GET"
                class="search-field position-relative mt-4 mb-3">
                <div class="position-relative">
                    <input class="search-field__input w-100 border rounded-1" type="text" name="search-keyword"
                        placeholder="Search products">
                    <button class="btn-icon search-popup__submit pb-0 me-2" type="submit">
                        <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_search" />
                        </svg>
                    </button>
                    <button class="btn-icon btn-close-lg search-popup__reset pb-0 me-2" type="reset"></button>
                </div>
                <div class="position-absolute start-0 top-100 m-0 w-100">
                    <div class="search-result"></div>
                </div>
            </form>
        </div>
        <div class="container">
            <div class="overflow-hidden">
                <ul class="navigation__list list-unstyled position-relative">
                    <li class="navigation__item">
                        <a href="/" class="navigation__link">Home</a>
                    </li>
                    <li class="navigation__item">
                        <a href="/shop" class="navigation__link">Shop</a>
                    </li>
                    <li class="navigation__item">
                        <a href="/about" class="navigation__link">About</a>
                    </li>
                    <li class="navigation__item">
                        <a href="/contact" class="navigation__link">Contact</a>
                    </li>
                    <li class="navigation__item">
                        <a href="/support" class="navigation__link">Support</a>
                    </li>
                    @guest
                        @if (Route::has('login'))
                            <li class="navigation__item">
                                <a href="{{ route('login') }}" class="navigation__link">Login</a>
                            </li>
                        @endif
                    @else
                        <li class="navigation__item">
                            <a href="#" class="navigation__link js-nav-right d-flex align-items-center">Account<svg
                                    class="ms-auto" width="7" height="11" viewBox="0 0 7 11"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_next_sm" />
                                </svg></a>
                            <div class="sub-menu position-absolute top-0 start-100 w-100 d-none">
                                <a href="#"
                                    class="navigation__link js-nav-left d-flex align-items-center border-bottom mb-2"><svg
                                        class="me-2" width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg>{{ Auth::user()->name }}</a>
                                <ul class="list-unstyled">
                                    <li class="sub-menu__item"><a href="{{ route('account.dashboard') }}"
                                            class="menu-link menu-link_us-s">Account</a></li>
                                    <li class="sub-menu__item"><a href="{{ route('account.orders') }}"
                                            class="menu-link menu-link_us-s">Orders</a></li>
                                    <li class="sub-menu__item d-lg-none"><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                                            class="menu-link menu-link_us-s">Logout</a></li>
                                    <li class="sub-menu__item d-lg-none">
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>
