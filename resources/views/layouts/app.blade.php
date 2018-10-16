<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Creative - Start Bootstrap Theme</title>

    <!-- Bootstrap core CSS -->
     <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free/css/all.min.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link href="{{asset('css/magnific-popup/magnific-popup.css')}}" rel="stylesheet">
    <!-- Ionicons -->
   <link href="{{asset('css/creative.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<!--     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" /> -->

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="{{asset('img/logo.png')}}"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="{{url('login')}}">ログイン</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="{{('register/2')}}">ユーザー登録</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="{{url('register/1')}}">クリエイター登録</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="nav-link js-scroll-trigger" href="{{ url('guide')}}">ご利用ガイド</a>
                <a class="nav-link js-scroll-trigger" href="{{url('questions')}}">よくある質問</a>
                <a class="nav-link js-scroll-trigger" href="contact.html">お問い合わせフォーム</a>
                <a href="{{ route('logout') }}" class="nav-link js-scroll-trigger" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                    Logout
                </a>    
                <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
              </div>
            </li>
            
            
          </ul>
        </div>
      </div>
    </nav>

    @yield('content')

    <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{asset('js/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('js/scrollreveal/scrollreveal.min.js')}}"></script>
    <script src="{{asset('js/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
  </body>

</html>
