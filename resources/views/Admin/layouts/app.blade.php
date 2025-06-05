<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sokna Admin')</title>

    @vite('resources/css/app.css')
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="flex bg-gray-100 text-gray-900">

    

   



    <!-- Main content -->

    <div class="flex-1 p-6">

        @yield('content')

    </div>



</body>

</html>