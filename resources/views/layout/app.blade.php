<!DOCTYPE html>
<html lang="pt" class="has-navbar-fixed-top">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scout</title>
    <link rel="stylesheet" href="{{ asset('/bulma/css/bulma.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('/app/main.css')  }}">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body>
<section class="section">
    <nav class="navbar is-fixed-top is-danger has-shadow" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <span class="navbar-item">
                Scout
            </span>
        </div>
        <div class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item is-active" href="{{  url('/')  }}">
                    Dashboard
                </a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="columns">
            <div class="column is-full">
                @yield('content')
            </div>
        </div>
    </div>
</section>
</body>
</html>
