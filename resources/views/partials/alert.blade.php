@if (session()->has('success'))
    <x-alert :message="session('success')"></x-alert>
@endif

@if (session()->has('error'))
    <x-alert type='danger' :message="session('success')"></x-alert>
@endif
