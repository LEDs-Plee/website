<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Is het toilet bezet?</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body class="antialiased">
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Is het toilet bezet?</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        @foreach($toilets as $toilet)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $toilet->name }}</h4>
                    </div>
                    <svg class="card-img-bottom" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 100 100" version="1.1">
                        <circle cx="50" cy="50" r="50" fill="#5e5e5e"/>
                        <path fill="none" stroke="{{ $toilet->free ? '#0ea800' : 'red'}}" stroke-width="10" stroke-linecap="round" d="M30,25 a30,30 0 0,1 40,0"/>
                        <circle cx="50" cy="50" r="20" fill="#808080"/>
                        <line {!! $toilet->free ? 'x1="50" y1="35" x2="50" y2="65"' : 'x1="35" y1="50" x2="65" y2="50"' !!} stroke="#474747" stroke-width="5" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
