<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Niu Homecare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="w-full bg-gray-50">

@include('layout.header')

    <div id="beranda" class="h-screen bg-gray-50">
        @include('components.homepage')
    </div>
    <div id="layanan" class="h-sreen bg-mainColor">
        @include('components.layanan')
    </div>
    <div id="pesan" class="h-screen bg-gray-50">
        @include('components.pesan')
    </div>

@include('layout.scrollUpButton')

@include('layout.footer')

</body>

</html>
