<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Twitch App</title>
  </head>
  <body>
  <div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col-8 text-center">
        <h1>Twitch app</h1>
        </div>
        <div class="col"></div>
    </div>
        <div class="row">
        <div class="col"></div>
        <div class="col-8">
        @yield('content')
        </div>
        <div class="col"></div>
    </div>
  </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins and Typeahead) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Typeahead.js Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script>
    jQuery(document).ready(function($){
        // Set the Options for "Bloodhound" suggestion engine
        var engine = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/search-game?q=%QUERY%',
                    wildcard: '%QUERY%'
                },
            });

        $("#search-game").typeahead({
            hint: true,
            highlight: true,
            minLength: 3,
            limit: 10
        },
        {
        name: 'game-title',
        source: engine.ttAdapter(),
        display: 'name',
        templates: {
            empty: [
                '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
            ],
            header: [
                '<div class="card" style="width: 18rem;"><ul class="list-group list-group-flush">'
            ],
            suggestion: function (data) {
                return '<li class="list-group-item" id="'+data.id+'">' + data.name + '</li>'
            },
            footer: [
                '</ul></div>'
            ]
        }
        });
        $('#search-game').bind('typeahead:select', function(ev, suggestion) {
            //console.log(suggestion.id);
            $('#gameId').val(suggestion.id);
        });
    })
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>