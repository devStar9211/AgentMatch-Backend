
@extends('layouts.app')
@section('content')
<header class="masthead text-center text-white d-flex pt-150px">
  <div class="container my-auto">
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <h1 class="text-uppercase">
          <strong>Creator Works</strong>
        </h1>
        <h2 class="text-uppercase">
          <strong>あなたのアイデアを形にしてみませんか？</strong>
        </h2>
        <hr>
      </div>
      <div class="col-lg-8 mx-auto">
        <a class="btn btn-primary btn-xl js-scroll-trigger" href="login" style="width:200px">ログイン</a>
        <a class="btn btn-info btn-xl js-scroll-trigger" href="register/2" style="width:200px">ユーザー登録</a>
        <a class="btn btn-success btn-xl js-scroll-trigger" href="register/1" style="width:200px">クリエイター登録</a>
      </div>
    </div>
  </div>
</header>
<section id="services">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-heading">サービス内容</h2>
        <hr class="my-4">
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card" >
          <img class="card-img-top" src="{{asset('img/top/ekaki.jpg')}}" alt="Card image" style="width:100%; height: 400px">
          <div class="card-body">
            <p class="card-text">LINEのスタンプ、着せ替えを作りたい人とクリエターと結ぶマッチングサービスです。</p>
            <!-- <a href="#" class="btn btn-primary">See Profile</a> -->
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img class="card-img-top" src="{{ asset('img/top/sample.png') }}" alt="Card image" style="width:100%; height: 400px">
          <div class="card-body">
            <!-- <h4 class="card-title">John Doe</h4> -->
            <p class="card-text">クリエター様は、自分の作品を載せることができます。作りたい人は、それを見てメッセージを送ることができます。<br>真ん中の画像の文字の追加をしてください。下記記載します。
また、ユーザー様は、作りたいイメージのアイデアを投稿することができ、それを見たクリエイター様もメッセージを送ることができます。</p>
            <!-- <a href="#" class="btn btn-primary">See Profile</a> -->
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card" >
          <img class="card-img-top" src="{{ asset('img/top/akushu.jpg')}}" alt="Card image" style="width:100%; height: 400px">
          <div class="card-body">
            <!-- <h4 class="card-title">John Doe</h4> -->
            <p class="card-text">支払いが済むと、クリエター様が作業を開始し、一緒に理想のスタンプ、着せ替えを作っていくことができます。</p>
            <!-- <a href="#" class="btn btn-primary">See Profile</a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row" style="padding-bottom: 30px;">
      <div class="col-md-4">
        <img src="img/user.png" alt="User image" style="width: 200px; padding-top: 30px">
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <p>
              <h3 style="color: #2A5C95">ユーザー様料金</h3>
            </p>
          </div>
          <div class="card-body">
            <p>
              <span>スタンプ40個</span>+<span>メイン画像１個</span>+<span>トークルームタブ画像１個</span><br>21600円
            </p>
            <p>
              <span>アニメーション24個</span>+<span>メイン画像１個</span>+<span>トークルームタブ画像１個</span><br>27000円
            </p>
            <p>
              <span>着せ替え1個</span><br>32400円
            </p>
          </div>
          
        </div>
      </div>
    </div>
    <div class="row">
      
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <p>
              <h3 style="color: #2BE984">クリエター様報酬</h3>
            </p>
          </div>
          <div class="card-body">
            <p>
              <span>LINEのスタンプ、着せ替えを作りたい人とクリエターと結ぶマッチングサービスです。 スタンプ40個</span>+<span>メイン画像１個</span>+<span>トークルームタブ画像１個</span><br>15000円
            </p>
            <p>
              <span>アニメーション24個</span>+<span>メイン画像１個</span>+<span>トークルームタブ画像１個</span><br>22000円
            </p>
            <p>
              <span>着せ替え1個</span><br>25000円
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <img src="img/creator.png" alt="Creator image" style="width: 200px; padding-top: 30px; float: right;">
      </div>
    </div>
  </div>
</section>

@endsection