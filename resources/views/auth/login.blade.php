@extends('layouts.app')

@section('content')
<!-- <header class="masthead text-center text-white d-flex">
      <div class="container my-auto wrap-login100">
        <form class="login100-form validate-form">
          <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
            <span class="label-input100">メールアドレス</span>
            <input class="input100" type="text" name="username" placeholder="メールアドレス">
            <span class="focus-input100"></span>
          </div>

          <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
            <span class="label-input100">パスワード</span>
            <input class="input100" type="password" name="pass" placeholder="パスワード">
            <span class="focus-input100"></span>
          </div>

          <div class="flex-sb-m w-full p-b-30">
            <div class="contact100-form-checkbox">
              <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
              <label class="label-checkbox100" for="ckb1">
                Remember me
              </label>
            </div>

            <div style="color: #808080;">パスワードをお忘れの方は
              <a href="forgot_pass.html" class="txt1">
                こちら
              </a>
            </div>
          </div>

          <div class="container-login100-form-btn">
            <a class="login100-form-btn" href="creator_top.html">
              ログイン
            </a>
          </div>
        </form>
      </div>
    </header> -->
<header class="masthead text-center text-white d-flex">
  <div class="container my-auto wrap-login100">
    <form method="POST" class="login100-form validate-form" action="{{ route('login') }}">
        @csrf


      <div class="wrap-input100 validate-input m-b-26 form-group" data-validate="Username is required">
        <span class="label-input100">メールアドレス</span>
        <input id="email" type="email" class="input100 form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"  placeholder="メールアドレス" name="email" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>

      <div class="wrap-input100 validate-input m-b-18 form-group" data-validate = "Password is required">
        <span class="label-input100">パスワード</span>
        <input id="password" type="password" class="input100 form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="パスワード" name="password" required>

        @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif
        
      </div>

      <div class="flex-sb-m w-full p-b-30 form-group contact100-form-checkbox">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>
       
        <div style="color: #808080;">パスワードをお忘れの方は
          <a class="btn btn-link txt1" href="{{ route('password.request') }}">
              {{ __('こちら') }}
          </a>
          
        </div>
      </div>

      <div class="container-login100-form-btn">
        <button type="submit" class="btn btn-primary login100-form-btn">
            {{ __('ログイン') }}
        </button>
      </div>


        <!-- <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                

                
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            </div>
        </div> -->
    </form>
     
</div>
</header>
@endsection
