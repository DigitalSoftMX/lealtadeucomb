@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'login',
'title' => __('Eucomb'),
'pageBackground' => asset("material").'/img/component.png'
])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-8 ml-auto mr-auto">
            <img class="mx-auto d-block" src="{{ asset('storage/logos') }}/logo.png" width="50%" />
  
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="card card-login card-hidden">
                    <span class="form-group  bmd-form-group{{ $errors->has('login') ? ' has-danger' : '' }}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            <input type="text" class="form-control" id="exampleEmails" name="login"
                                placeholder="{{ __('Correo electrónico / Usuario') }}"  required>
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            @include('alerts.feedback', ['field' => 'login'])
                        </div>
                    </span>
                </div>
                
                
                <div class="card card-login card-hidden">
                    <span class="form-group bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            <input type="password" class="form-control" id="examplePassword" name="password"
                                placeholder="{{ __('Contraseña') }}" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                    </span>
                </div>
                <div>
                    <button type="submit" class="btn rose rounded" style="background:#71BF4F">{{ __('Ingresar') }}</button>
                <!--    <button type="submit" class="btn rose rounded pull-right" style="background-color: transparent;">{{ __('Registrarse') }}</button>-->
                </div>
                {{-- Falta configurar para reset de pass --}}
                <a class="btn btn-link" href="{{route('password.request')}}" id="r-pass" style="color:#71BF4F">¿Olvidates tu contraseña?</a>
            </form>
        </div>
    </div>
</div>
{{-- 
    
        
    




{{-- <div class="card-body ">
                    <div class="form-check mr-auto ml-3 mt-3">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember"
                                {{ old('remember') ? 'checked' : '' }}> {{ __('Recordar Contraseña') }}
<span class="form-check-sign">
    <span class="check"></span>
</span>
</label>
</div>
</div> --}}

{{-- </form> 
</div> --}}

{{-- <div class="card card-login card-hidden">
                    {{-- <div class="card-header card-header-rose text-center">
                        <h4 class="card-title">{{ __('Login') }}</h4>
</div>

<div class="card-body ">
    <span class="form-group  bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="material-icons">email</i>
                </span>
            </div>
            <input type="text" class="form-control" id="exampleEmails" name="email" placeholder="{{ __('Correo electrónico...') }}"
                value="" required>
            @include('alerts.feedback', ['field' => 'email'])
        </div>
    </span>
    <span class="form-group bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                </span>
            </div>
            <input type="password" class="form-control" id="examplePassword" name="password"
                placeholder="{{ __('Contraseña...') }}" required>
            @include('alerts.feedback', ['field' => 'password'])
        </div>
    </span>
    <div class="form-check mr-auto ml-3 mt-3">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            {{ __('Recordar Contraseña') }}
            <span class="form-check-sign">
                <span class="check"></span>
            </span>
        </label>
    </div>
</div>
<div class="card-footer justify-content-center">
    <button type="submit" class="btn btn-rose btn-link btn-lg">{{ __('Aceptar') }}</button>
</div> --}}
{{-- </div> --}}
{{-- </form>
    </div>
</div>
</div> --}}



<style>
    body {
        background-color: #1A7B34;
    }

    #r-pass {
        color: white;
    }

</style>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        md.checkFullPageBackgroundImage();
        setTimeout(function () {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 10);
    });

</script>
@endpush
