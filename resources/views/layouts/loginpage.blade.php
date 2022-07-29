<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Informasi Inventaris Barang | Futake</title>

    {{-- STYLE --}}
    @stack('before-style')
    @yield('style-custom')
    @stack('after-style')

</head>

<body>
    <div id="wrapper">

        {{-- CONTENT --}}

        @yield('content')

    {{-- SCRIPT --}}
    @stack('before-script')
    @yield('script-custom')
    @stack('after-script')

</body>
</html>
