@extends('layouts.app', ['activePage' => 'category-management', 'menuParent' => 'laravel', 'titlePage' => ' '])

<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/logoEucomb.png">
 <link rel="icon" type="image/png" href="{{ asset('material') }}/img/logoEucomb.png">
 
@section('content')
<div class="content">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                          <i class="material-icons">category</i>
                        </div>
                        <h4 class="card-title">Pago efectuado</h4>
                        {{-- <h4 class="card-title">{{$catalog->getName()}}</h4> --}}
                    </div>
                    <div class="card-body">
                        <form action="{{route('efectuado',$valor)}}" autocomplete="off" class="form-horizontal" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                           <div class="row">
                                <div class="col-6">
                                    <h4></h4>
                                <label for="">Archivo del pago efectuado</label>
                                
                                <input type="file" class="form-control" name="fileKey" required>
                                
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
