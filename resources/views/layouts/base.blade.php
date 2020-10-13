
<html>
    <head>
        <link href = "{{asset('css/app.css')}}" rel = "stylesheet">
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        
        <title> {{ $titulo ?? '' }} </title>
        <meta name = "csrf-token" content = "{{ csrf_token() }}">
        <style>
            body{
                padding: 20px;
            }
            .navbar{
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class = "container-fluid">
            @component('component_navbar', ["current" => $current])
            @endcomponent
            <main role = "main">
                @hasSection('body')
                    @yield('body')
                @endif
            </main>
        </div>
    </body>
    <script src="{{asset('js/app.js')}}" type = "text/javascript"> </script>
    <script src = "{{asset('js/chart.js') }}"></script>
    @hasSection('javascript')
        @yield('javascript')
    @endif
</html>