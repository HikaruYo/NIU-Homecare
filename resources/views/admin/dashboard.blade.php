<!doctype html>
<html lang="en" class="scroll-smooth overscroll-none no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Pengguna')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="w-full h-screen bg-gray-50">

{{-- Default values untuk menghindari error variable undefined --}}
@php
    $currentTab = $currentTab ?? 'dashboard';
    $short = $short ?? 'Admin';
@endphp

<div class="flex w-full h-screen">

    {{-- Sidebar --}}
    <div class="w-1/5 p-2">
        @include('admin.components.sideBarAdmin', ['currentTab' => $currentTab, 'short' => $short])
    </div>

    {{-- Content --}}
    <div class="w-4/5 p-2">
        @yield('content')
    </div>

</div>

</body>
</html>
