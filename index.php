/*
* @package noshare4vids.com
* @author Andreas Loukakis, alou@alou.gr
*/
//This is not the actual index.php file but has all the partials making the html, the server side is via Laravel
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="x-csrf-token" content="{{ csrf_token() }}">
    <meta property="og:image" content="{{ asset('/static/images/og.png') }}" />
    <title>No click share to view videos</title>
    <meta name="description" content="No, I wont click share to view your stupid content!">
    <link href="{{asset('/static/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{asset('/static/css/theme.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Favicons -->
  </head>
  <body>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-52191921-1', 'noshare4vid.com');
      ga('send', 'pageview');

    </script>
    <nav class="navbar" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('/static/images/logo.png') }}" alt="No share for vids"></a>
        </div>
        
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          
          
          <ul class="nav navbar-nav navbar-right">
            
            @if(isset($served))
            <li class="served">
                Found 
                <strong><span id="counter">
                {{ $served }}
                </span></strong>
                 videos so far.
            </li>
            @endif
            
            <li class="{{ (Route::is('home')) ? 'active' : null }}"><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
            <li>
                <a class="{{ (Route::is('contact')) ? 'active' : null }}" href="{{ route('contact') }}"><span class="glyphicon glyphicon-pencil"></span> Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container mainc">
       @include('site::_partials/notifications')
        <h1 class="blue">Don't click Share to reveal content.<br /><small>I know you hate it, so put the URL of the page below and hit Show Me.</small></h1>
         {{ Form::open(array('class' => 'searchvids', 'action' => 'postvid', 'id' => 'searchvids') ) }}
        <div class="input-group input-group-lg">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-link"></span></span>
                  {{ Form::text('vidurl', '', array('placeholder' => 'http://www.someUrl.com', 'class' => 'form-control')) }}
         </div>
         <br />
         <div class="input-group input-group-lg">
            <span class="input-group-addon"><span class="glyphicon glyphicon-facetime-video"></span></span>
            {{ Form::submit('Show Me', array('class' => 'btn btn-primary form-control', 'id' => 'showme')) }}
         </div>
         <div id="videos" class="text-center">
            <?php
            if (isset($videos)) {
                echo "Found ".count($videos)." hidden videos!";
                foreach ($videos as $vid){
                    echo '<div class="video"><iframe width="700" height="500" src="//www.youtube.com/embed/'.$vid.'" frameborder="0" allowfullscreen></iframe></div>';
                }
            }
            ?>
         </div>
    </div>
        <footer class="footer">
        <div class="container text-center">
            We really hate it when ugly things happen on the web. Popups and like / share to see content are some of those...<br />
            Currently, this will catch youtube vids from most common plugins, <a href="{{ route('contact') }}">let me know</a>. Created by <a href="http://www.alou.gr/">alou.gr</a>
        </div>
    </footer>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
     <script src="{{ URL::asset('static/js/snap.svg-min.js') }}"></script>
    <script src="{{ asset('/static/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('/static/js/app.js') }}"></script>
  </body>
</html>
