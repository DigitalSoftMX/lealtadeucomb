<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
  <div class="container">
    {{-- <div class="navbar-wrapper">     
    </div> --}}
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="sr-only">Toggle navigation</span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        @auth()
          <li class="nav-item">
              <a href="https://eucomb.lealtaddigitalsoft.mx/public/logout" class="nav-link" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                  <i class="material-icons">directions_run</i>
                  <span>{{ __('Salir') }}</span>
              </a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>