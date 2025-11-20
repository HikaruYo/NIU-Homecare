<!doctype html>
<html lang="en" class="scroll-smooth overscroll-none no-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Niu Homecare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="w-full bg-gray-50 h-screen">
@if(Auth::check())
    @php
        $user = auth()->user();
        $full = $user->username;
        $short = strlen($full) > 20 ? substr($full, 0, 20) . '..' : $full;
        $email = $user->email;
        $no_hp = $user->no_hp;
        $alamat = $user->alamat;

        $currentTab = request()->query('tab', 'profil'); // default profil
    @endphp
@endif

<div class="flex w-full">
    {{-- Side Bar --}}
    <div class="p-2 h-screen w-1/5">
        @include('components.sideBar', ['currentTab' => $currentTab])
    </div>

    {{-- Content Area --}}
    <div class="h-screen w-4/5 p-2 overflow-y-auto bg-gray-50">
        @if ($currentTab === 'profil')
            @include('components.profil')
        @elseif ($currentTab === 'histori')
            @include('components.histori')
        @else
            {{-- Fallback: Jika tab tidak valid --}}
            @include('components.profil')
        @endif
    </div>

</div>

</body>
</html>
