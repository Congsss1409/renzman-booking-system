<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Renzman Booking')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- fullPage.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/3.1.2/fullpage.min.css" />

    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            overflow-x: hidden; /* Prevents horizontal scrollbar */
        }
        /* Style adjustments for fullPage.js integration */
        .fp-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem 1.5rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    @yield('content')

    <!-- fullPage.js JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/3.1.2/fullpage.min.js"></script>
</body>
</html>

