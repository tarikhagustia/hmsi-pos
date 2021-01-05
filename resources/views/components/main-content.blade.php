<div>
    <section class="section">
        @if (!is_null($title) || !is_null($bread))
            <div class="section-header">
                @if (!is_null($title))
                    <h1>{{ $title }}</h1>
                @endif

                @if (!is_null($bread))
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="#">Layout</a></div>
                        <div class="breadcrumb-item">Default Layout</div>
                    </div>
                @endif
            </div>
        @endif

        <div class="section-body">
            {{ $slot }}
        </div>
    </section>
</div>
