<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div id="app">
            {{-- O componente principal do Vue (App.vue) será montado aqui --}}
        </div>

        {{-- Exemplo de como você pode passar dados do backend para o componente Vue --}}
        {{-- Certifique-se de que $workoutDataJson seja uma string JSON válida --}}
        <workout-display
            workout-json="{{ $workoutDataJson ?? '' }}"
        ></workout-display>

        {{-- Se você quiser que o WorkoutDisplay seja parte do seu App.vue, você o usaria lá dentro. --}}
        {{-- Caso contrário, ele será renderizado como um componente Vue separado na página. --}}
    </body>
</html>
