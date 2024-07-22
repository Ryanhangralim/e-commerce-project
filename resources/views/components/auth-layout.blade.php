<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Custom title for every page --}}
    <title>{{ $title ?? 'Auth Page' }}</title>

    @include('includes.head')

    @yield('css')

</head>

<body id="page-top" class="bg-gradient-primary">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        {{ $slot }}

    </div>
    
    @include('includes.script')

    {{-- Custom scripts --}}
    @yield('script')
</body>

</html>