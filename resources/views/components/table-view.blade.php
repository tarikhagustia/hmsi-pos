<div class="card">
    <div class="card-header">
        <h4>{{ $title }}</h4>
        @if ($searchable)
            <div class="card-header-form">
                <form method="GET">
                    <input class="form-control" type="text" name="search" placeholder="Cari..." autocomplete="off" value="{{ request('search') }}">
                </form>
            </div>
        @endif
        @if (!is_null($action))
            <div class="card-header-action{{ $searchable ? ' ml-3' : '' }}">
                {{ $actions ?? null }}
                <a class="btn btn-primary" href="{{ $action }}">Tambah</a>
            </div>
        @endif
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
    @if (!is_null($pagination))
        <div class="card-footer text-right">
            {!! $pagination !!}
        </div>
    @endif
</div>
