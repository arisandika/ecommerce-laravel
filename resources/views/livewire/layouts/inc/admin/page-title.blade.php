<div class="row">
    <div class="col-12">
        <div class="page-title-box row">
            <div class="col-8 col-md-6 d-flex align-items-center">
                <h4 class="font-size-18">@yield('title')</h4>
            </div>

            @yield('back-link')

            @if (session('message'))
                <!-- Alert for message -->
                <div class="col-12 col-md-6">
                    <div class="alert alert-primary alert-dismissible fade show mt-4 mt-md-0" role="alert">
                        <i class="mdi mdi-check-all me-2"></i>
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
