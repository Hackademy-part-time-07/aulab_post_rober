
<head>
    <title>{{$title ?? 'Aulab Post'}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
    <x-navbar />
    {{$slot}}
    <x-footer />
  </body>