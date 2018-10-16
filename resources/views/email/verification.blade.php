@extends('layouts.app')
@section('content')
<header class="masthead text-center text-white d-flex pt-150px">
  <div class="container my-auto">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 text-center mt-5">
      <div class="panel panel-default">
        <div class="panel-heading">Registration</div>
          <div class="panel-body">
          {{$user -> email}}宛に
            メールを送信しました。

            メールに記載されているURLを
            クリックしてください。

        </div>
      </div>
    </div>
  </div>
</div>
</header>
@endsection