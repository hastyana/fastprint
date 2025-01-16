<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">  
    
    <title>{{ (isset($second_title) && !empty($second_title) ? $second_title.' - ' : '').''.($title ?? env('APP_NAME')) }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">    
    <link href="{{ asset('img/logo/logo.png') }}" rel="icon">
    <link href="{{ asset('img/logo/logo.png') }}" rel="apple-touch-icon">

    <!-- Favicons -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- Fontisto Icons -->
    <link href="https://cdn.jsdelivr.net/npm/fontisto@3.0.4/css/fontisto/fontisto.min.css" rel="stylesheet">

    <!-- Talwind CSS Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- css additional -->
    @yield('plugin_css')
    @yield('add_css')
</head>

<body>
    
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200 font-roboto">
        {{-- Sidebar --}}
        @include('cms.admin.partials.sidebar')
        
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Header --}}
            @include('cms.admin.partials.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                    {{-- Content --}}
                    @yield('content')

                </div>
            </main>

            {{-- Footer --}}
            @include('cms.admin.partials.footer')

        </div>        
    </div>

    {{-- Back to Top --}}
    @include('cms.admin.partials.back-to-top')

    <!-- js additional -->
    @yield('plugin_js')
    @yield('add_js')

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

</body>

</html>