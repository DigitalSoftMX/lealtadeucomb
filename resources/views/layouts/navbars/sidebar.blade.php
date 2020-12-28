<div class="sidebar" data-color="azure" style="background: #1A7B34">
   
    <div class="logo text-center"  id="logo" style="background: #FFFFFF">
    <img class="mx-auto d-block" src="{{ asset('storage/logos') }}/logo.png" width="50%" /></div>
    <div class="sidebar-wrapper" id="menu">
        <ul class="nav">
            
          <ul class="nav">
            <li>
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            
            
             @permission('*perfil-sho')
            <li>
                <a class="nav-link" href="{{ url('perfil') }}">
                    <i class="material-icons">account_circle</i>
                    <p>{{ __('Perfil') }}</p>
                </a>
            </li>
            @endpermission
           
          @permission('adminM_userempresas-sho')
           
         <li class="nav-item {{ $menuParent == 'material' ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#laravelExample" {{ $menuParent == 'laravel' ? ' aria-expanded="true"' : '' }}>
             <span class="icon-target"><i class="material-icons">person</i></span>
              <p>{{ __('Usuarios') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'material' ? ' show' : '' }}" id="laravelExample">
              <ul class="nav">
                <!--<li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('userempresas') }}">
                      <span class="sidebar-mini"><i class="material-icons">apartment</i></span>
                      <span class="sidebar-normal">{{ __('Representante') }} </span>
                    </a>
                </li>-->
                @endpermission
                @permission('adminM_userclient-sho')
                <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('userclient') }}">
                    <span class="sidebar-mini"><i class="material-icons">people_alt</i></span>
                    <span class="sidebar-normal">{{ __('Clientes') }} </span>
                  </a>
                </li>
                @endpermission
                @permission('adminM_userstation-sho')
                <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('userstation') }}">
                    <span class="sidebar-mini"><i class="material-icons">assignment_ind</i></span>
                    <span class="sidebar-normal">{{ __('Encargado de Estación') }} </span>
                  </a>
                </li>
                @endpermission
               @permission('adminG_movement-sho')
                <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('movement') }}">
                    <span class="sidebar-mini"><i class="material-icons">people_alt</i></span>
                    <span class="sidebar-normal">{{ __('Folios') }} </span>
                  </a>
                </li>
                @endpermission
                
                @permission('*usuario-sho')
                <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('usuarioconmaspuntos') }}">
                    <span class="sidebar-mini"><i class="material-icons">note_add</i></span>
                    <span class="sidebar-normal">{{ __('Clientes con más Puntos') }} </span>
                  </a>
                </li>
                
                 @role('admin_usuarios')
            <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('catestaciones') }}">
                    <span class="sidebar-mini"> <i class="material-icons">place</i> </span>
                    <span class="sidebar-normal">{{ __('Estaciones') }} </span>
                  </a>
                </li>
            @endrole

           
              </ul>
            </div>
          </li>
              @endpermission
           
    
        @permission('adminM_empresas-sho')
         <li class="nav-item {{ $menuParent == 'material' ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#catalogos" {{ $menuParent == 'catalogos' ? ' aria-expanded="true"' : '' }}>
             <span class="icon-target"><i class="material-icons">apps</i></span>
              <p>{{ __('Catálogos') }}
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse {{ $menuParent == 'material' ? ' show' : '' }}" id="catalogos">
              <ul class="nav">
                <!--    <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ url('empresas') }}">
                        <span class="sidebar-mini"><i class="material-icons">business</i></span>
                        <span class="sidebar-normal">{{ __('Empresas') }} </span>
                      </a>
                    </li>-->
                <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('catestaciones') }}">
                    <span class="sidebar-mini"> <i class="material-icons">place</i> </span>
                    <span class="sidebar-normal">{{ __('Estaciones') }} </span>
                  </a>
                </li>
                <!--<li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('catbombas') }}">
                    <span class="sidebar-mini"><i class="material-icons">local_gas_station</i></span>
                    <span class="sidebar-normal">{{ __('Bombas') }} </span>
                  </a>
                </li>-->
                @permission('*catprecios-sho')
                <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('catprecios') }}">
                    <span class="sidebar-mini"> <i class="material-icons">attach_money</i> </span>
                    <span class="sidebar-normal">{{ __('Precios') }} </span>
                  </a>
                </li>
                @endpermission
                <!-- LEALTAD -->
               @role('admin_master')
               <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('adminvoucher') }}">
                    <span class="sidebar-mini"> <i class="material-icons">view_list</i> </span>
                    <span class="sidebar-normal">{{ __('Administración de Vales') }} </span>
                  </a>
                </li>
                <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('adminawards') }}">
                    <span class="sidebar-mini"> <i class="material-icons">redeem</i> </span>
                    <span class="sidebar-normal">{{ __('Administración de Premios') }} </span>
                  </a>
                </li>
               <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('doblepuntos') }}">
                    <span class="sidebar-mini"> <i class="material-icons">add</i> </span>
                    <span class="sidebar-normal">{{ __('Puntos Dobles') }} </span>
                  </a>
                </li>
               @endrole
              </ul>
            </div>
          </li>
          @endpermission
       
            @role('admin_estacion')    
             <li>
                <a class="nav-link" href="{{ url('userclient') }}">
                    <i class="material-icons">people_alt</i>
                    <p>{{ __('Clientes') }}</p>
                </a>
            </li>
            @endpermission
            
           @permission('adminE_exchange-sho')
           <li>
                <a class="nav-link" href="{{ url('procesoexchange') }}">
                    <i class="material-icons">data_usage</i>
                    <p>{{ __('Canje') }}</p>
                </a>
            </li>
            @endpermission
            
            @permission('adminG_adminhistory-sho')
           <li>
                <a class="nav-link" href="{{ url('history') }}">
                    <i class="material-icons">event_note</i>
                    <p>{{ __('Historial') }}</p>
                </a>
            </li>
            @endpermission
            
           @permission('adminM_conjuntomembership-sho')
           <li>
                <a class="nav-link" href="{{ url('conjuntomembership') }}">
                    <i class="material-icons">save_alt</i>
                    <p>{{ __('Agrupar Membresías') }}</p>
                </a>
            </li>
            @endpermission
           
            @permission('adminM_facturas-sho')
            <li>
                <a class="nav-link" href="{{ url('facturas') }}">
                    <i class="material-icons">assignment</i>
                    <p>{{ __('Facturas') }}</p>
                </a>
            </li>
            @endpermission
            @permission('adminM_pagos-sho')
            <li>
                <a class="nav-link" href="{{ url('pagos') }}">
                    <i class="material-icons">payment</i>
                    <p>{{ __('Abonos') }} <span id="notificacion" class="badge badge-default pull-right" style="background-color:#FF0900"></span>
                 </p>
                </a>
            </li>
            @endpermission
            
           <!-- @permission('adminM_graficas-sho')
            <li>
                <a class="nav-link" href="{{ url('graficas') }}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Gráficas') }}</p>
                </a>
            </li>
            @endpermission
            -->
            @permission('usuario_usermembership-sho')
            <li>
                <a class="nav-link" href="{{ url('usermemberships') }}">
                    <i class="material-icons">assignment</i>
                    <p>{{ __('Mi Membresía') }}</p>
                </a>
            </li>
            @endpermission
            
            @permission('usuario_usermovement-sho')
            <li>
                <a class="nav-link" href="{{ url('usuariomovement') }}">
                    <i class="material-icons">people_alt</i>
                    <p>{{ __('Mi Estado de Cuenta') }}</p>
                </a>
            </li>
            @endpermission
            
            @permission('usuario_exchange-sho')
            <li>
                <a class="nav-link" href="{{ url('usuarioexchange') }}">
                    <i class="material-icons">data_usage</i>
                    <p>{{ __('Mis Canjes') }}</p>
                </a>
            </li>
            @endpermission
            
            @permission('usuario_history-sho')
            <li>
                <a class="nav-link" href="{{ url('usuariohistory') }}">
                    <i class="material-icons">event_note</i>
                    <p>{{ __('Mi Historial') }}</p>
                </a>
            </li>
            @endpermission
            
             <!-- Vales -->
            @permission('usuario_voucher-sho')
            <li>
                <a class="nav-link" href="{{ url('voucher') }}">
                    <i class="material-icons">event_note</i>
                    <p>{{ __('Solicitud de Vales') }}</p>
                </a>
            </li>
            @endpermission
           
            
            
            
        </ul>
    </div>
</div>
<style>
    #logo {
        height: 30%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #menu{
        height: 70%;
    }

</style>
