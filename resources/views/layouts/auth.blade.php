<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title', 'Login') &mdash; {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('stylesheet')
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            @yield('content')
        </div>
    </section>
</div>
<script src="{{ mix('js/app.js') }}"></script>
@stack('javascript')
</body>
</html>
