<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Informasi Inventaris Barang | Futake</title>

    {{-- STYLE --}}
    @stack('before-style')
    @include('includes.style')
    @yield('style-custom')
    @stack('after-style')

</head>

<body>
    <div id="wrapper">

        {{-- SIDEBAR --}}
        @include('includes.sidebar')

        <div id="page-wrapper" class="gray-bg">

        {{-- NAVBAR --}}
        @include('includes.navbar')

        </div>

        {{-- CONTENT --}}

        @include('sweetalert::alert')
        @yield('content')

    {{-- SCRIPT --}}
    @stack('before-script')
    @include('includes.script')
    @yield('script-custom')
    @stack('after-script')

</body>
</html>
