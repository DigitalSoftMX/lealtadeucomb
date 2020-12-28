@extends('layouts.app', ['activePage' => 'form_regular', 'menuParent' => 'forms', 'titlePage' => __('')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mr-auto">
                <div class="card">
                    <h4 class="card-title ml-5 mt-5" style="font-size:25px; font-weight: bold;">
                        {{$catalog->getName()}}
                    </h4>
                    {{-- <div class="card-header card-header-rose card-header-text">
                        <div class="card-text">
                            h4
                        </div>
                    </div> --}}
                    <div class="card-body col-md-12 mx-auto" style="width: 95%;">
                        <table class="table table-striped table-hover" id="table_id">
                            {!! form_start($form) !!}
                            {!! form_rest($form) !!}
                        </table>
                    </div>
                    <div class="clearfix ">
                        <button type="submit" class="btn btn-primary pull-left ml-5">Aceptar</button>
                         <button type="button" class="btn btn-primary pull-left ml-5" onclick="window.location='{{ url($catalog->getUrlPrefix()) }}'">Regresar</button>
                     </div>
                    <div class="clearfix ">
                     </div>
                    {!! form_end($form) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('select2/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/newselect.js') }}"></script>
<script src="{{ asset('plugins/newselectlealtad.js') }}"></script>

@endpush
