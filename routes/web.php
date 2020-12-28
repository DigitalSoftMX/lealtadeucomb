<?php

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/public/login', 'HomeController@index')->name('home');
Route::get('storage-link', function(){
           Artisan::call('storage:link');
           });
           
Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
Route::get('dashboard', 'HomeController@index')->name('home');
Route::get('graficas', 'HomeController@graficas')->name('grapics');
Route::post('graficasfilter', 'HomeController@graficasfilter')->name('grapic');
Route::get('error', ['as' => 'page.error', 'uses' => 'ExamplePagesController@error']);

  Route::group(['middleware' => 'auth'], function () {
  Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
  Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
  Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
  
     
  //------------------------------------------------------------------------------------
  //Catalogos
  //Administrador

  //Roles
  Route::resource('role', 'Catalogos\Admin\RoleController', ['except' => ['destroy', 'show']]); //llama al controlador
  Route::get('rolejlist', 'Catalogos\Admin\RoleController@getJlist'); //lista de la tabla
  Route::get('role/edit/{id}', 'Catalogos\Admin\RoleController@getEdit'); //metodo para mostrar en edit
  Route::post('role/edit/{id}', 'Catalogos\Admin\RoleController@postEdit'); //metodo para guardar en edit
  Route::get('role/add', 'Catalogos\Admin\RoleController@getAdd'); //metodo para abrir add
  Route::post('role/add', 'Catalogos\Admin\RoleController@postAdd'); //metodo para guardar en add

  //Permisos
  Route::resource('permission', 'Catalogos\Admin\PermissionController', ['except' => ['destroy', 'show']]); //llama al controlador
  Route::get('permissionjlist', 'Catalogos\Admin\PermissionController@getJlist'); //lista de la tabla
  Route::get('permission/edit/{id}', 'Catalogos\Admin\PermissionController@getEdit'); //metodo para mostrar en edit
  Route::post('permission/edit/{id}', 'Catalogos\Admin\PermissionController@postEdit'); //metodo para guardar en edit
  Route::get('permission/add', 'Catalogos\Admin\PermissionController@getAdd'); //metodo para abrir add
  Route::post('permission/add', 'Catalogos\Admin\PermissionController@postAdd'); //metodo para guardar en add

  /**************************************************** CATALOGOS  ***********************************************************************************/

  //Usuarios o Clientes
  Route::resource('userclient', 'Catalogos\Admin\UserClientController', ['except' => ['destroy', 'show']]);
  Route::get('userclientjlist', 'Catalogos\Admin\UserClientController@getJlist');
  Route::get('userclient/edit/{id}', 'Catalogos\Admin\UserClientController@getEdit');
  Route::post('userclient/edit/{id}', 'Catalogos\Admin\UserClientController@postEdit')->name('registerclientedit');
  Route::get('userclient/add', 'Catalogos\Admin\UserClientController@getAdd');
  Route::post('userclient/add', 'Catalogos\Admin\UserClientController@postAdd')->name('registerclient');
  Route::get('userclient/destroy/{id}', 'Catalogos\Admin\UserClientController@getDestroy');
  Route::get('userclient/ver/{id}', 'Catalogos\Lealtad\MovementController@getVer');
  Route::post('userclient/ver/{id}', 'Catalogos\Lealtad\MovementController@postVer');
  Route::post('userclientjfilter', 'Catalogos\Admin\UserClientController@postJFilter'); //filtro
  
  //Usuarios Estaciones
  Route::resource('userstation', 'Catalogos\Admin\UserEstacionesController', ['except' => ['destroy', 'show']]);
  Route::get('userstationjlist', 'Catalogos\Admin\UserEstacionesController@getJlist');
  Route::get('userstation/edit/{id}', 'Catalogos\Admin\UserEstacionesController@getEdit');
  Route::post('userstation/edit/{id}', 'Catalogos\Admin\UserEstacionesController@postEdit')->name('registerusers');
  Route::get('userstation/add', 'Catalogos\Admin\UserEstacionesController@getAdd');
  Route::post('userstation/add', 'Catalogos\Admin\UserEstacionesController@postAdd')->name('registeruser');
  Route::get('userstation/destroy/{id}', 'Catalogos\Admin\UserEstacionesController@getDestroy');
   
 //Usuarios o Empresas
  Route::resource('userempresas', 'Catalogos\Admin\UserEmpresasController', ['except' => ['destroy', 'show']]);
  Route::get('userempresasjlist', 'Catalogos\Admin\UserEmpresasController@getJlist');
  Route::get('userempresas/edit/{id}', 'Catalogos\Admin\UserEmpresasController@getEdit');
  Route::post('userempresas/edit/{id}', 'Catalogos\Admin\UserEmpresasController@postEdit')->name('registerempresa');
  Route::get('userempresas/add', 'Catalogos\Admin\UserEmpresasController@getAdd');
  Route::post('userempresas/add', 'Catalogos\Admin\UserEmpresasController@postAdd')->name('registerempres');
  Route::get('userempresas/destroy/{id}', 'Catalogos\Admin\UserEmpresasController@getDestroy');
  Route::get('userempresas/ver/{id}', 'Catalogos\Admin\UserEmpresasController@getVer');
  Route::post('userempresas/ver/{id}', 'Catalogos\Admin\UserEmpresasController@postVer');


  //Rutas catalogos estaciones

  Route::resource('catestaciones', 'Catalogos\Admin\CatEstacionesController', ['except' => ['destroy', 'show']]);
  Route::get('catestacionesjlist', 'Catalogos\Admin\CatEstacionesController@getJlist');
  Route::get('catestacionesjlistt/{id}', 'Catalogos\Admin\CatEstacionesController@getJlistt');
  Route::get('catestaciones/edit/{id}', 'Catalogos\Admin\CatEstacionesController@getEdit');
  Route::post('catestaciones/edit/{id}', 'Catalogos\Admin\CatEstacionesController@postEdit')->name('registerestaciones');
  Route::get('catestaciones/add', 'Catalogos\Admin\CatEstacionesController@getAdd');
  Route::post('catestaciones/add', 'Catalogos\Admin\CatEstacionesController@postAdd')->name('registerestacion');
  Route::get('catestaciones/destroy/{id}', 'Catalogos\Admin\CatEstacionesController@getDestroy');
  Route::get('catestaciones/ver/{id}', 'Catalogos\Admin\CatBombasController@getVer');
  Route::post('catestaciones/ver/{id}', 'Catalogos\Admin\CatBombasController@postVer');
  Route::get('catestaciones/fac/{id}', 'Catalogos\Admin\CatBombasController@getFac');
  Route::post('catestaciones/fac/{id}', 'Catalogos\Admin\CatBombasController@postFac')->name('negocio');
  Route::get('catestacionesjlistt/{id}', 'Catalogos\Admin\CatEstacionesController@getJListt');
  Route::post('catestaciones/pac/{id}', 'Catalogos\Admin\CatEstacionesController@postPac')->name('paquet');
  

  // Rutas catalogos facturas

  Route::resource('catfacturas', 'Catalogos\Admin\CatFacturasController', ['except' => ['destroy', 'show']]);
  Route::get('catfacturasjlist', 'Catalogos\Admin\CatFacturasController@getJList');
  Route::get('catfacturas/edit/{id}', 'Catalogos\Admin\CatFacturasController@getEdit');
  Route::post('catfacturas/edit/{id}', 'Catalogos\Admin\CatFacturasController@postEdit');
  Route::get('catfacturas/add', 'Catalogos\Admin\CatFacturasController@getAdd');
  Route::post('catfacturas/add', 'Catalogos\Admin\CatFacturasController@postAdd');
  Route::get('catfacturas/destroy/{id}', 'Catalogos\Admin\CatFacturasController@getDestroy');
  Route::get('catfacturas/ver/{id}', 'Catalogos\Admin\CatFacturasController@getVer');
  Route::post('catfacturas/ver/{id}', 'Catalogos\Admin\CatFacturasController@postVer');

  //Rutas Empresas

  Route::resource('empresas', 'Catalogos\Admin\EmpresasController', ['except' => ['destroy', 'show']]);
  Route::get('empresasjlist', 'Catalogos\Admin\EmpresasController@getJList');
  Route::get('empresas/edit/{id}', 'Catalogos\Admin\EmpresasController@getEdit');
  Route::post('empresas/edit/{id}', 'Catalogos\Admin\EmpresasController@postEdit');
  Route::get('empresas/add', 'Catalogos\Admin\EmpresasController@getAdd');
  Route::post('empresas/add', 'Catalogos\Admin\EmpresasController@postAdd');
  Route::get('empresas/destroy/{id}', 'Catalogos\Admin\EmpresasController@getDestroy');
  Route::get('empresas/ver/{id}', 'Catalogos\Admin\CatEstacionesController@getVer');
  Route::post('empresas/ver/{id}', 'Catalogos\Admin\CatEstacionesController@postVer');
  
  //Rutas Facturas

  Route::resource('facturas', 'Catalogos\Admin\FacturasController', ['except' => ['destroy', 'show']]);
  Route::get('facturasjlist', 'Catalogos\Admin\FacturasController@getJList');
  Route::get('facturas/edit/{id}', 'Catalogos\Admin\FacturasController@getEdit');
  Route::post('facturas/edit/{id}', 'Catalogos\Admin\FacturasController@postEdit');
  Route::get('facturas/add', 'Catalogos\Admin\FacturasController@getAdd');
  Route::post('facturas/add', 'Catalogos\Admin\FacturasController@postAdd');
  Route::get('facturas/destroy/{id}', 'Catalogos\Admin\FacturasController@getDestroy');
  Route::get('facturas/ver/{id}', 'Catalogos\Admin\FacturasController@getVer');
  Route::post('facturas/ver/{id}', 'Catalogos\Admin\FacturasController@postVer')->name('factura');
  Route::get('facturas/pdf', 'Catalogos\Admin\FacturasController@xmlbdpdf')->name('pdf');
  Route::get('facturasjlistt/{id}', 'Catalogos\Admin\FacturasController@getJListt');
  // Route::get('factura/PDF', 'pdfController@exportPDF')->name('factura.pdf');
  

  // Rutas pagos

  Route::resource('pagos', 'Catalogos\Admin\PagosController', ['except' => ['destroy', 'show']]);
  Route::get('pagosjlist', 'Catalogos\Admin\PagosController@getJList');
  Route::get('pagos/edit/{id}', 'Catalogos\Admin\PagosController@getEdit');
  Route::post('pagos/edit/{id}', 'Catalogos\Admin\PagosController@postEdit')->name('efectuado');
  Route::get('pagos/add', 'Catalogos\Admin\PagosController@getAdd');
  Route::post('pagos/add', 'Catalogos\Admin\PagosController@postAdd');
  Route::get('pagos/destroy/{id}', 'Catalogos\Admin\PagosController@getDestroy');
  Route::get('pagos/ver/{id}', 'Catalogos\Admin\PagosController@getVer');
  Route::post('pagos/ver/{id}', 'Catalogos\Admin\PagosController@postVer')->name('pago');
  
  Route::resource('pagosautorizados', 'Catalogos\Admin\PagosAutorizadosController', ['except' => ['destroy', 'show']]);
  Route::get('pagosautorizadosjlist', 'Catalogos\Admin\PagosAutorizadosController@getJList');
  Route::get('pagosautorizados/edit/{id}', 'Catalogos\Admin\PagosAutorizadosController@getEdit');
  Route::post('pagosautorizados/edit/{id}', 'Catalogos\Admin\PagosAutorizadosController@postEdit');
  Route::get('pagosautorizados/add', 'Catalogos\Admin\PagosAutorizadosController@getAdd');
  Route::post('pagosautorizados/add', 'Catalogos\Admin\PagosAutorizadosController@postAdd');
  Route::get('pagosautorizados/destroy/{id}', 'Catalogos\Admin\PagosAutorizadosController@getDestroy');
  Route::get('pagosautorizados/ver/{id}', 'Catalogos\Admin\PagosAutorizadosController@getVer');
  Route::post('pagosautorizados/ver/{id}', 'Catalogos\Admin\PagosAutorizadosController@postVer');

  Route::resource('pagoshistorial', 'Catalogos\Admin\PagosHistorialController', ['except' => ['destroy', 'show']]);
  Route::get('pagoshistorialjlist', 'Catalogos\Admin\PagosHistorialController@getJList');
  Route::get('pagoshistorial/edit/{id}', 'Catalogos\Admin\PagosHistorialController@getEdit');
  Route::post('pagoshistorial/edit/{id}', 'Catalogos\Admin\PagosHistorialController@postEdit');
  Route::get('pagoshistorial/add', 'Catalogos\Admin\PagosHistorialController@getAdd');
  Route::post('pagoshistorial/add', 'Catalogos\Admin\PagosHistorialController@postAdd');
  Route::get('pagoshistorial/destroy/{id}', 'Catalogos\Admin\PagosHistorialController@getDestroy');
  Route::get('pagoshistorial/ver/{id}', 'Catalogos\Admin\PagosHistorialController@getVer');
  Route::post('pagoshistorial/ver/{id}', 'Catalogos\Admin\PagosHistorialController@postVer');

  //Precios

  Route::resource('catprecios', 'Catalogos\Admin\CatPreciosController', ['except' => ['destroy', 'show']]);
  Route::get('catpreciosjlist', 'Catalogos\Admin\CatPreciosController@getJList');
  Route::get('catprecios/edit/{id}', 'Catalogos\Admin\CatPreciosController@getEdit');
  Route::post('catprecios/edit/{id}', 'Catalogos\Admin\CatPreciosController@postEdit');
  Route::get('catprecios/add', 'Catalogos\Admin\CatPreciosController@getAdd');
  Route::post('catprecios/add', 'Catalogos\Admin\CatPreciosController@postAdd');
  Route::get('catprecios/destroy/{id}', 'Catalogos\Admin\CatPreciosController@getDestroy');
  Route::get('catprecios/ver/{id}', 'Catalogos\Admin\CatPreciosController@getVer');
  Route::post('catprecios/ver/{id}', 'Catalogos\Admin\CatPreciosController@postVer');

  // Bombas

  Route::resource('catbombas', 'Catalogos\Admin\CatBombasController', ['except' => ['destroy', 'show']]);
  Route::get('catbombasjlist', 'Catalogos\Admin\CatBombasController@getJList');
  Route::get('catbombas/edit/{id}', 'Catalogos\Admin\CatBombasController@getEdit');
  Route::post('catbombas/edit/{id}', 'Catalogos\Admin\CatBombasController@postEdit');
  Route::get('catbombas/add', 'Catalogos\Admin\CatBombasController@getAdd');
  Route::post('catbombas/add', 'Catalogos\Admin\CatBombasController@postAdd');
  Route::get('catbombas/destroy/{id}', 'Catalogos\Admin\CatBombasController@getDestroy');
  Route::get('catbombas/ver/{id}', 'Catalogos\Admin\FacturasController@getVer');
  Route::post('catbombas/ver/{id}', 'Catalogos\Admin\FacturasController@postVer');
  Route::get('catbombasjlistt/{id}', 'Catalogos\Admin\CatBombasController@getJListt');
  
  ///********************************************* USUARIOS *************************************************************************************
  
  //Mi Membresia de usuario
     Route::resource('usermemberships', 'Catalogos\Usuarios\MembershipsController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('usermembershipsjlist', 'Catalogos\Usuarios\MembershipsController@getJlist'); //lista de la tabla
     Route::get('usermemberships/edit/{id}', 'Catalogos\Usuarios\MembershipsController@getEdit');//metodo para mostrar en edit
     Route::post('usermemberships/edit/{id}', 'Catalogos\Usuarios\MembershipsController@postEdit');//metodo para guardar en edit
     Route::get('usermemberships/add', 'Catalogos\Usuarios\MembershipsController@getAdd');//metodo para abrir add
     Route::post('usermemberships/add', 'Catalogos\Usuarios\MembershipsController@postAdd');//metodo para guardar en add
     Route::get('usermemberships/destroy/{id}', 'Catalogos\Usuarios\MembershipsController@getDestroy');//metodo para abrir add
     
   //Mi Movimientos o Estado de Cuenta
     Route::resource('usuariomovement', 'Catalogos\Usuarios\MovementController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('usuariomovementjlist', 'Catalogos\Usuarios\MovementController@getJlist'); //lista de la tabla
     
  //Vales Usuario
     Route::resource('voucher', 'Catalogos\Usuarios\VoucherController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('voucherjlist', 'Catalogos\Usuarios\VoucherController@getJlist'); //lista de la tabla
     Route::get('voucher/edit/{id}', 'Catalogos\Usuarios\VoucherController@getEdit');//metodo para mostrar en edit
     Route::post('voucher/edit/{id}', 'Catalogos\Usuarios\VoucherController@postEdit');//metodo para guardar en edit
     Route::get('voucher/add', 'Catalogos\Usuarios\VoucherController@getAdd');//metodo para abrir add
     Route::post('voucher/add', 'Catalogos\Usuarios\VoucherController@postAdd');//metodo para guardar en add
     Route::get('voucher/destroy/{id}', 'Catalogos\Usuarios\VoucherController@getDestroy');//metodo para abrir add
     
     //Mis Vales
     Route::resource('usuarioexchange', 'Catalogos\Usuarios\ExchangeController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('usuarioexchangejlist', 'Catalogos\Usuarios\ExchangeController@getJlist'); //lista de la tabla
     
     //historial usuarios
     Route::resource('usuariohistory', 'Catalogos\Usuarios\HistoryController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('usuariohistoryjlist', 'Catalogos\Usuarios\HistoryController@getJlist'); //lista de la tabla
     
     
  ///********************************************* LEALTAD ADMINISTRADR***************************************************************************
  
  //Perfil
     Route::resource('perfil', 'Catalogos\Lealtad\PerfilController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('perfiljlist', 'Catalogos\Lealtad\PerfilController@getJlist'); //lista de la tabla
     Route::get('perfil/edit/{id}', 'Catalogos\Lealtad\PerfilController@getEdit');//metodo para mostrar en edit
     Route::post('perfil/edit/{id}', 'Catalogos\Lealtad\PerfilController@postEdit');//metodo para guardar en edit
     Route::get('perfil/add', 'Catalogos\Lealtad\PerfilController@getAdd');//metodo para abrir add
     Route::post('perfil/add', 'Catalogos\Lealtad\PerfilController@postAdd');//metodo para guardar en add
     
   //Vales Admin
     Route::resource('adminvoucher', 'Catalogos\Lealtad\VoucherController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('adminvoucherjlist', 'Catalogos\Lealtad\VoucherController@getJlist'); //lista de la tabla
     Route::get('adminvoucher/edit/{id}', 'Catalogos\Lealtad\VoucherController@getEdit');//metodo para mostrar en edit
     Route::post('adminvoucher/edit/{id}', 'Catalogos\Lealtad\VoucherController@postEdit')->name('agregarvales');//metodo para guardar en edit
     Route::get('adminvoucher/add', 'Catalogos\Lealtad\VoucherController@getAdd');//metodo para abrir add
     Route::post('adminvoucher/add', 'Catalogos\Lealtad\VoucherController@postAdd');//metodo para guardar en add
     Route::get('adminvoucher/destroy/{id}', 'Catalogos\Lealtad\VoucherController@getDestroy');//metodo para abrir add
  
   //Contador de Vales o Agrega Vales
     Route::resource('countvouchers', 'Catalogos\Lealtad\CountVaucherController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('countvouchersjlist', 'Catalogos\Lealtad\CountVaucherController@getJlist'); //lista de la tabla
     Route::get('countvouchers/edit/{id}', 'Catalogos\Lealtad\CountVaucherController@getEdit');//metodo para mostrar en edit
     Route::post('countvouchers/edit/{id}', 'Catalogos\Lealtad\CountVaucherController@postEdit');//metodo para guardar en edit
     Route::get('countvouchers/add', 'Catalogos\Lealtad\CountVaucherController@getAdd');//metodo para abrir add
     Route::post('countvouchers/add', 'Catalogos\Lealtad\CountVaucherController@postAdd');//metodo para guardar en add
     Route::get('countvouchers/destroy/{id}', 'Catalogos\Lealtad\CountVaucherController@getDestroy');//metodo para abrir add
    
      //Puntos Dobles
     Route::resource('doblepuntos', 'Catalogos\Lealtad\DoblePuntosController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('doblepuntosjlist', 'Catalogos\Lealtad\DoblePuntosController@getJlist'); //lista de la tabla
     Route::get('doblepuntos/edit/{id}', 'Catalogos\Lealtad\DoblePuntosController@getEdit');//metodo para mostrar en edit
     Route::post('doblepuntos/edit/{id}', 'Catalogos\Lealtad\DoblePuntosController@postEdit');//metodo para guardar en edit
     Route::get('doblepuntos/add', 'Catalogos\Lealtad\DoblePuntosController@getAdd');//metodo para abrir add
     Route::post('doblepuntos/add', 'Catalogos\Lealtad\DoblePuntosController@postAdd');//metodo para guardar en add
     Route::get('doblepuntos/destroy/{id}', 'Catalogos\Lealtad\DoblePuntosController@getDestroy');//metodo para abrir add
     
      //Proceso admin estacion
     Route::resource('procesoexchange', 'Catalogos\AdminEstacion\ProcesoController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('procesoexchangejlist', 'Catalogos\AdminEstacion\ProcesoController@getJlist'); //lista de la tabla
     Route::post('procesoexchangejlistt', 'Catalogos\AdminEstacion\ProcesoController@Jlistt'); //lista de la tabla
     Route::get('procesoexchange/edit/{id}', 'Catalogos\AdminEstacion\ProcesoController@getEdit');//metodo para mostrar en edit
     Route::post('procesoexchange/edit/{id}', 'Catalogos\AdminEstacion\ProcesoController@postEdit');//metodo para guardar en edit
     Route::post('procesoexchangejfilter', 'Catalogos\AdminEstacion\ProcesoController@postJFilter'); //filtro
  
     //Entregar admin estacion
     Route::resource('entregaexchange', 'Catalogos\AdminEstacion\EntregaController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('entregaexchangejlist', 'Catalogos\AdminEstacion\EntregaController@getJlist'); //lista de la tabla
     Route::post('entregaexchangejlistt', 'Catalogos\AdminEstacion\EntregaController@Jlistt'); //lista de la tabla
     Route::get('entregaexchange/edit/{id}', 'Catalogos\AdminEstacion\EntregaController@getEdit');//metodo para mostrar en edit
     Route::post('entregaexchange/edit/{id}', 'Catalogos\AdminEstacion\EntregaController@postEdit');//metodo para guardar en edit
     Route::post('entregaexchangejfilter', 'Catalogos\AdminEstacion\EntregaController@postJFilter'); //filtro
  
     //Cobrar admin estacion
     Route::resource('cobrarexchange', 'Catalogos\AdminEstacion\CobrarController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('cobrarexchangejlist', 'Catalogos\AdminEstacion\CobrarController@getJlist'); //lista de la tabla
     Route::post('cobrarexchangejlistt', 'Catalogos\AdminEstacion\CobrarController@Jlistt'); //lista de la tabla
     Route::get('cobrarexchange/edit/{id}', 'Catalogos\AdminEstacion\CobrarController@getEdit');//metodo para mostrar en edit
     Route::post('cobrarexchange/edit/{id}', 'Catalogos\AdminEstacion\CobrarController@postEdit');//metodo para guardar en edit
     Route::post('cobrarexchangejfilter', 'Catalogos\AdminEstacion\CobrarController@postJFilter'); //filtro
  
     //Recibido admin estacion
     Route::resource('recibidoexchange', 'Catalogos\AdminEstacion\RecibidoController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('recibidoexchangejlist', 'Catalogos\AdminEstacion\RecibidoController@getJlist'); //lista de la tabla
     Route::get('recibidoexchange/edit/{id}', 'Catalogos\AdminEstacion\RecibidoController@getEdit');//metodo para mostrar en edit
     Route::post('recibidoexchange/edit/{id}', 'Catalogos\AdminEstacion\RecibidoController@postEdit');//metodo para guardar en edit
     
      //historial
     Route::resource('history', 'Catalogos\Lealtad\HistoryController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('historyjlist', 'Catalogos\Lealtad\HistoryController@getJlist'); //lista de la tabla
     Route::post('historyjlistt', 'Catalogos\Lealtad\HistoryController@Jlistt'); //lista de la tabla
     Route::post('historyjfilter', 'Catalogos\Lealtad\HistoryController@postJFilter'); //filtro
  
       //Vales Usuario Master
     Route::resource('adminmvoucher', 'Catalogos\Lealtad\AdminMVoucherController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('adminmvoucherjlist', 'Catalogos\Lealtad\AdminMVoucherController@getJlist'); //lista de la tabla
     Route::get('adminmvoucher/edit/{id}', 'Catalogos\Lealtad\AdminMVoucherController@getEdit');//metodo para mostrar en edit
     Route::post('adminmvoucher/edit/{id}', 'Catalogos\Lealtad\AdminMVoucherController@postEdit');//metodo para guardar en edit
    
     //Agregar tickets usuario master 
     Route::resource('conjuntomembership', 'Catalogos\Lealtad\ConjuntoMembershipController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('conjuntomembershipjlist', 'Catalogos\Lealtad\ConjuntoMembershipController@getJlist'); //lista de la tabla
     Route::post('conjuntomembershipjlistt', 'Catalogos\Lealtad\ConjuntoMembershipController@Jlistt'); //lista de la tabla
     Route::get('conjuntomembership/edit/{id}', 'Catalogos\Lealtad\ConjuntoMembershipController@getEdit');//metodo para mostrar en edit
     Route::post('conjuntomembership/edit/{id}', 'Catalogos\Lealtad\ConjuntoMembershipController@postEdit');//metodo para guardar en edit
     Route::get('conjuntomembership/add', 'Catalogos\Lealtad\ConjuntoMembershipController@getAdd');//metodo para abrir add
     Route::post('conjuntomembership/add', 'Catalogos\Lealtad\ConjuntoMembershipController@postAdd');//metodo para guardar en add
     Route::get('conjuntomembership/destroy/{id}', 'Catalogos\Lealtad\ConjuntoMembershipController@getDestroy');//metodo para abrir add
     
     //Cambio de Membresia
     Route::resource('changememberships', 'Catalogos\Lealtad\Change_MembershipsController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('changemembershipsjlist', 'Catalogos\Lealtad\Change_MembershipsController@getJlist'); //lista de la tabla
    
    //Movimientos
     Route::resource('movement', 'Catalogos\Lealtad\MovementController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('movementjlist', 'Catalogos\Lealtad\MovementController@getJlist'); //lista de la tabla
     Route::get('movementjlistt/{id}', 'Catalogos\Lealtad\MovementController@getJListt');
     Route::get('movement/edit/{id}', 'Catalogos\Lealtad\MovementController@getEdit');//metodo para mostrar en edit
     Route::post('movement/edit/{id}', 'Catalogos\Lealtad\MovementController@postEdit');//metodo para guardar en edit
     Route::get('movement/add', 'Catalogos\Lealtad\MovementController@getAdd');//metodo para abrir add
     Route::post('movement/add', 'Catalogos\Lealtad\MovementController@postAdd');//metodo para guardar en add
     Route::get('movement/destroy/{id}', 'Catalogos\Lealtad\MovementController@getDestroy');//metodo para abrir add
     Route::get('movement/ver/{id}', 'Catalogos\Lealtad\MovementController@getVer');
     Route::post('movement/ver/{id}', 'Catalogos\Lealtad\MovementController@postVer');
     Route::post('movementjfilter', 'Catalogos\Lealtad\MovementController@postJFilter'); //filtro
  
     //Usuario con mas puntos
     Route::resource('usuarioconmaspuntos', 'Catalogos\Lealtad\UsuariosMasVistosController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('usuarioconmaspuntosjlist', 'Catalogos\Lealtad\UsuariosMasVistosController@getJlist'); //lista de la tabla
     Route::post('usuarioconmaspuntosjlistt', 'Catalogos\Lealtad\UsuariosMasVistosController@Jlistt'); //filtro
     Route::get('usuarioconmaspuntos/edit/{id}', 'Catalogos\Admin\UserClientController@getEdit');//metodo para mostrar en edit
     Route::post('usuarioconmaspuntos/edit/{id}', 'Catalogos\Admin\UserClientController@postEdit')->name('registerclientedit');//metodo para guardar en edit
     Route::get('usuarioconmaspuntos/ver/{id}', 'Catalogos\Lealtad\MovementController@getVer');
     Route::post('usuarioconmaspuntos/ver/{id}', 'Catalogos\Lealtad\MovementController@postVer');
  
     //Usuario Detalle de puntos
     Route::resource('usuariodetalle', 'Catalogos\Lealtad\UsuarioDetallesController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('usuariodetallejlist', 'Catalogos\Lealtad\UsuarioDetallesController@getJlist'); //lista de la tabla
     
      //Premios Admin
     Route::resource('adminawards', 'Catalogos\Lealtad\AwardsController', ['except' => ['destroy', 'show']]); //llama al controlador
     Route::get('adminawardsjlist', 'Catalogos\Lealtad\AwardsController@getJlist'); //lista de la tabla
     Route::get('adminawards/edit/{id}', 'Catalogos\Lealtad\AwardsController@getEdit');//metodo para mostrar en edit
     Route::post('adminawards/edit/{id}', 'Catalogos\Lealtad\AwardsController@postEdit')->name('premioedit');//metodo para guardar en edit
     Route::get('adminawards/add', 'Catalogos\Lealtad\AwardsController@getAdd');//metodo para abrir add
     Route::post('adminawards/add', 'Catalogos\Lealtad\AwardsController@postAdd')->name('premioadd');//metodo para guardar en add
     Route::get('adminawards/destroy/{id}', 'Catalogos\Lealtad\AwardsController@getDestroy');//metodo para abrir add


});


    Route::get('download/{id}', 'Catalogos\Admin\CatBombasController@getDownload')->name('pagedown');
    Route::get('downloadcer/{id}', 'Catalogos\Admin\CatBombasController@getDownloadcer');
    Route::get('downloadkey/{id}', 'Catalogos\Admin\CatBombasController@getDownloadkey');
    Route::get('downloadconsituacion/{id}', 'Catalogos\Admin\CatBombasController@getDownloadConsituacion');
    Route::get('downloadpdf/{id}', 'Catalogos\Admin\CatBombasController@getDownloadPDF');

    //select2
    Route::get('selectsex', 'Catalogos\Admin\UserClientController@getAjaxlistaSex');
    Route::get('selectactivo', 'Catalogos\Admin\UserClientController@getAjaxlistaActivo');
    Route::get('selectempresa', 'Catalogos\Admin\UserClientController@getAjaxlistaEmpresa');
    Route::get('selectbomba', 'Catalogos\Admin\UserClientController@getAjaxlistaBomba');
    Route::get('selectestacion', 'Catalogos\Admin\UserClientController@getAjaxlistaEstacion');
    Route::get('selectuser', 'Catalogos\Admin\UserClientController@getAjaxlistaUser');
    Route::get('selectprecios', 'Catalogos\Admin\UserClientController@getAjaxlistaPrecios');


    //select2 lealtad
     Route::get('selectactive', 'Catalogos\Admin\UserClientController@getAjaxlistaActive');
     Route::get('selecttype', 'Catalogos\Admin\UserClientController@getAjaxlistaType');
     Route::get('selectcomes', 'Catalogos\Admin\UserClientController@getAjaxlistaComes');
     Route::get('selectstatus', 'Catalogos\Admin\UserClientController@getAjaxlistaStatus');
     Route::get('selectdays_deliver', 'Catalogos\Admin\UserClientController@getAjaxlistaDays_Deliver');
     Route::get('selectstation', 'Catalogos\Admin\UserClientController@getAjaxlistaStation');
     Route::get('selectsusersfaturation', 'Catalogos\Admin\UserClientController@getAjaxlistaUsersFaturation');
     Route::get('selectstate', 'Catalogos\Admin\UserClientController@getAjaxlistaState');
     Route::get('selectmemberships', 'Catalogos\Admin\UserClientController@getAjaxlistaMemberships');
     Route::get('selectsusers', 'Catalogos\Admin\UserClientController@getAjaxlistaUsers');
     Route::get('selectsgraphics', 'Catalogos\Admin\UserClientController@getAjaxlistaGraphics');
     Route::get('selectedad', 'Catalogos\Admin\UserClientController@getAjaxlistaEdad');
    
    Route::get('notification', 'Catalogos\Admin\UserClientController@getAjaxlistaNotification');
 

    Route::post('apilogin', 'ApiUser\LoginController@login');
    Route::post('apiregistrar', 'ApiUser\LoginController@registrar');
    Route::get('apiperfil' , 'ApiUser\PerfilController@perfil');
    Route::get('apiperfilios' , 'ApiUser\PerfilController@perfilIOS');
    Route::post('apiperfilupdate', 'ApiUser\PerfilController@perfilupdate');
    Route::get('apicerrar', 'ApiUser\LoginController@cerrar');
   
    Route::get('apidatosfactura' , 'ApiUser\DatosFacturacionController@datosfactura');
    Route::post('apidatosfacturaupdate', 'ApiUser\DatosFacturacionController@datosfacturaupdate');
    Route::post('apiestadocuenta' , 'ApiUser\EstadoCuentaController@estadocuenta');
    Route::get('apiestaciones' , 'ApiUser\EstadoCuentaFacturaController@estaciones');
    Route::post('apiestadocuentafactura' , 'ApiUser\EstadoCuentaFacturaController@estadocuenta');
    
    Route::post('apivisual', 'ApiUser\VisualController@visual');
    //Route::post('apitimbrar', 'ApiUser\TimbradoController@timbrar');
    Route::get('apitimbrar', 'ApiUser\FacturarController@facturar');
    Route::post('apisticket', 'ApiLealtad\NewTicketsController@principal');
    Route::post('apiqrformulario', 'ApiLealtad\NewTicketsController@principalformulario');
    //Route::get('apisticket', 'ApiLealtad\NewTicketsController@principal');
    Route::get('apistation1', 'ApiLealtad\Station1Controller@principal');
    Route::get('apistation2', 'ApiLealtad\Station2Controller@principal');
    Route::get('apistation3', 'ApiLealtad\Station3Controller@principal');
    Route::get('apistation4', 'ApiLealtad\Station4Controller@principal');
    Route::get('apistation5', 'ApiLealtad\Station5Controller@principal');
    Route::get('apistation6', 'ApiLealtad\Station6Controller@principal');
    Route::get('apistation7', 'ApiLealtad\Station7Controller@principal');
    Route::get('apistation8', 'ApiLealtad\Station8Controller@principal');
    
    
   
   //LEALTAD
    Route::post('apisuser', 'ApiUser\MovEstateController@registrar');
    Route::get('apimembresia', 'ApiLealtad\MembresiaController@membresia');
    Route::get('apimembresiaestadocuenta', 'ApiLealtad\MembresiaController@membresiaestadocuenta');
    Route::get('apipuntos', 'ApiLealtad\MembresiaController@puntos');
    Route::post('apimovimientos', 'ApiLealtad\EstadoCuentaController@estadocuenta');
    Route::get('apivale', 'ApiLealtad\ValeController@vale');
    Route::get('apiexchangedisponibles', 'ApiLealtad\ExchangeController@exchangeDisponibles');
    Route::post('apiagregarvale', 'ApiLealtad\ValeController@agregarvale');
    Route::get('apiexchange', 'ApiLealtad\ExchangeController@exchange');
    Route::get('apiexchangepremios', 'ApiLealtad\ExchangeController@exchangepremios');
    Route::get('apiexchangedisponiblespremios', 'ApiLealtad\ExchangeController@exchangeDisponiblespremios');
    
    Route::get('apipremio', 'ApiLealtad\ValeController@premio');
    Route::get('apipremioestacion', 'ApiLealtad\ValeController@premioestacion');
    Route::post('apiagregarpremio', 'ApiLealtad\ValeController@agregarpremio');
    
    Route::get('apimembresiaios', 'ApiLealtad\MembresiaController@membresiaIOS');
    Route::get('apimembresiaestadocuentaios', 'ApiLealtad\MembresiaController@membresiaestadocuentaIOS');
    Route::post('apiestadocuentaios' , 'ApiUser\EstadoCuentaController@estadocuentaIOS');
    Route::get('apiestacionesios' , 'ApiUser\EstadoCuentaFacturaController@estacionesios');
    Route::post('apiestadocuentafacturaios' , 'ApiUser\EstadoCuentaFacturaController@estadocuentaIOS');
    Route::get('apidatosfacturaios' , 'ApiUser\DatosFacturacionController@datosfacturaIOS');
    Route::get('apivaleios', 'ApiLealtad\ValeController@valeIOS');
    Route::post('apiagregarvaleios', 'ApiLealtad\ValeController@agregarvaleIOS');
    Route::get('apipremioios', 'ApiLealtad\ValeController@premioIOS');
    Route::get('apiexchangepremiosios', 'ApiLealtad\ExchangeController@exchangepremiosIOS');
    Route::get('apiexchangedisponiblespremiosios', 'ApiLealtad\ExchangeController@exchangeDisponiblespremiosIOS');
    
    Route::get('apiexchangedisponiblesios', 'ApiLealtad\ExchangeController@exchangeDisponiblesIOS');
    Route::get('apiexchangeios', 'ApiLealtad\ExchangeController@exchangeIOS');
    Route::post('apiagregarpremioios', 'ApiLealtad\ValeController@agregarpremioIOS');
    
    
    
    
    
    
    
    
   
