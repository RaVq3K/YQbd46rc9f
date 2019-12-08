<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <title>Allegro Rest API</title>

    </head>
    <body>
        <div class="container">
        	<div class="col-12" align="center">
        		<h2>Allegro Rest API</h2>
        	</div>
    
        	<div class="col-12">
        		<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
				        <li class="breadcrumb-item"><a href="http://127.0.0.1:8000">Start</a></li>
                    @foreach ($memory as $key => $val)
                        <li class="breadcrumb-item"><a href="?query={{ $val['id'] }}&reverse={{ $key }}">{{ $val['name'] }}</a></li>
                    @endforeach
				  </ol>
				</nav>
        	</div>

        	<div class="col-12" align="right">
        		<a href="#"><button class="btn btn-sm btn-success">Autoryzuj</button></a>
        	</div>

        	<div class="col-12 mt-2">
        		<div class="jumbotron jumbotron-fluid" align="center">
				  <div class="container">
                @if ($Tokenexist != 0)    
                    @forelse ($Categories->categories as $category)
				    <a href="?query={{ $category->id }}">
                        <button class="btn btn-sm btn-outline-dark mx-auto my-1">{{ $category->name }}</button>
                    </a>
                    @empty
                    <p>To koniec danej kategorii osiągneliśmy maksymalny leaf</p>
                    @endforelse

                @else
                <p>Wpierw wykonaj autoryzację <br><small>(Symulowanie tego w Controllerze)</small></p>
                @endif
				  </div>
				</div>
        	</div>

        </div>
    </body>
</html>
