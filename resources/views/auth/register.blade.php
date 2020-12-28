@extends('layouts.app', [
  'class' => 'off-canvas-sidebar',
  'classPage' => 'register-page',
  'activePage' => 'register',
  'title' => __('Eucomb'),
  'pageBackground' => asset("material").'/img/logo.png'
])

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-5 ml-auto mr-auto">
      <div class="card card-signup">
        <h2 class="card-title text-center">{{ __('Registrarse') }}</h2>
        <div class="card-body">
          <div class="row">
            
            <div class="col-md-12 mr-auto">
              <div class="social text-center">
                <button class="btn btn-just-icon btn-round btn-twitter">
                  <i class="fa fa-twitter"></i>
                </button>
                <button class="btn btn-just-icon btn-round btn-facebook">
                  <i class="fa fa-facebook"> </i>
                </button>
                <h4 class="mt-3"> </h4>
              </div>
              <form class="form" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="has-default{{ $errors->has('name') ? ' has-danger' : '' }} mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">face</i>
                      </span>
                    </div>
                    <input type="text" name="name" class="form-control" placeholder="{{ __('Name...') }}" value="{{ old('name') }}" required>
                    @if ($errors->has('name'))
                      <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                        <strong>{{ $errors->first('nombre') }}</strong>
                      </div>
                     @endif
                  </div>
                </div>
                <div class="has-default{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">mail</i>
                      </span>
                    </div>
                    <input type="text" class="form-control" name="email" placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                      <div id="email-error" class="error text-danger pl-3" for="name" style="display: block;">
                        <strong>{{ $errors->first('email') }}</strong>
                      </div>
                     @endif
                  </div>
                </div>
                <div class="has-default{{ $errors->has('password') ? ' has-danger' : '' }} mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">lock_outline</i>
                      </span>
                    </div>
                    <input type="password" name="password" placeholder="{{ __('Contraseña...') }}" class="form-control" required>
                    @if ($errors->has('password'))
                      <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                        <strong>{{ $errors->first('password') }}</strong>
                      </div>
                     @endif
                  </div>
                </div>
                <div class="has-default mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">lock_outline</i>
                      </span>
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirmar Contraseña...') }}" required>
                  </div>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="policy" value="1" {{ old('policy', 1) ? 'checked' : '' }} >
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                    {{ __('Acepto') }} <a href="#">{{ __('terminos y condiciones') }}</a>
                  </label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary btn-round mt-4">{{ __('Aceptar') }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      md.checkFullPageBackgroundImage();
    });
  </script>
@endpush
