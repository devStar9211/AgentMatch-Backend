@extends('layouts.app')

@section('content')
<section class="pt-150px">
  <div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            <br>
            <hr>
            <hr>
            <br>
            <a href="login.html" class="btn btn-danger">ログイン</a><br/>
        </div>
        <div class="col-md-9 register-right">
            
            <div class="tab-content" id="myTabContent">
             <form method="POST" action="{{ route('register') }}">
              @csrf
              <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <h3  class="register-heading">ユーザー登録</h3>
                   <input id="role_id" type="hidden" name="role_id" value="">
                  <div class="row register-form">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="氏名（非公開）＊" value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                      </div>
                      <div class="form-group">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="メールアドレス *"  name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                           <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="パスワード *" name="password" required>

                            @if ($errors->has('password'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                            @endif
                          
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="パスワードを確認 *" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            {{ __('登録') }}
                        </button>
                        
                    </div>
                  </div>
              </div>
            </form>
            </div>
        </div>
    </div>

  </div>
</section>


@endsection
