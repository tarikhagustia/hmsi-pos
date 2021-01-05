<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" ontent="width=1024">
  <title>POS &dash; {{ config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ mix('css/pos.css') }}">
  @stack('stylesheet')
</head>
<body>
    <div id="app"></div>
    <script src="{{ mix('js/pos.js') }}"></script>
</body>
</html>
