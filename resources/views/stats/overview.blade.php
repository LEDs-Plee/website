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
        <h1 class="display-4">Toilet Stats</h1>
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
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Visits/Day</th>
                                <td>{{ $toilet->visitsPerDay() }}</td>
                            </tr>
                            <tr>
                                <th>Average Duration</th>
                                <td>{{ sprintf('%01d:%02d', floor($toilet->duration()/60), $toilet->duration()%60) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
