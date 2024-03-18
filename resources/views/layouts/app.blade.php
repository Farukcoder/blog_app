<html lang="en-us">
@include('layouts.includes.head')
<body>
    <!-- navigation -->
    @include('layouts.includes.navbar')
    <!-- /navigation -->

    @yield('mainSection')

    @include('layouts.includes.footer')

    @include('layouts.includes.script')
</body>
</html>
