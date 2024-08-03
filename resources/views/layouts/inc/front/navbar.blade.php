<header id="header" class="header header_sticky header-fullwidth">
    <div class="header-desk header-desk_type_5">
        <div class="logo">
            <a href="/">
                <img src="{{ asset('front/images/logo.jpg') }}" width="100" alt="Saintech" class="logo__image d-block">
            </a>
        </div>
        <nav class="navigation">
            <ul class="navigation__list list-unstyled d-flex">
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
            </ul>
        </nav>
        <div class="header-tools d-flex align-items-center">
            @guest
                @if (Route::has('login'))
                    <div class="header-tools__item hover-container">
                        <a class="header-tools__item" href="{{ route('login') }}">
                            <svg class="d-block" width="17" height="17" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_user" />
                            </svg>
                        </a>
                    </div>
                @endif
            @else
                <div class="nav-item dropdown">
                    <a id="navbarDropdown" class="fw-medium text-capitalize" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        aria-label="{{ Auth::user()->name }}" data-bs-placement="bottom" title="{{ Auth::user()->name }}"
                        v-pre>
                        {{ strlen(Auth::user()->name) > 11 ? substr(Auth::user()->name, 0, 10) . '...' : Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end mt-3" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('account.dashboard') }}">
                            Account
                        </a>
                        <a class="dropdown-item" href="{{ route('account.orders') }}">
                            My Order
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @endguest
            <div class="header-tools__item hover-container d-block">
                <div class="js-hover__open position-relative">
                    <a class="js-search-popup search-field__actor" href="#">
                        <svg class="d-block" width="17" height="17" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_search" />
                        </svg>
                        <i class="btn-icon btn-close-lg"></i>
                    </a>
                </div>
                <div class="search-popup js-hidden-content">
                    <form action="" method="GET" class="search-field container">
                        <p class="text-uppercase text-secondary fw-medium mb-4">What are you looking for?</p>
                        <div class="position-relative">
                            <input class="search-field__input search-popup__input w-100 fw-medium" type="text"
                                name="search-keyword" placeholder="Search products">
                            <button class="btn-icon search-popup__submit" type="submit">
                                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_search" />
                                </svg>
                            </button>
                            <button class="btn-icon btn-close-lg search-popup__reset" type="reset"></button>
                        </div>
                    </form>
                </div>
            </div>
            <a href="/cart" class="header-tools__item header-tools__cart" data-aside="cartDrawer">
                <svg class="d-block" width="17" height="17" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_cart" />
                </svg>
                <livewire:front.cart.cart-count />
            </a>
        </div>
    </div>
</header>
