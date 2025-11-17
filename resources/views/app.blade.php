<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Niu Homecare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="">

@include('layout.header')



    <div class="mx-28 mt-8 bg-gray-50">
        @include('components.homepage')
    </div>
    <div class="mx-28 bg-mainColor">
        @include('components.layanan')
    </div>


<div class="fixed bottom-4 right-6 cursor-pointer">
    arrow
</div>

@include('layout.footer')

</body>

</html>
