@extends('adminlte::page')

@section('title', 'Sistema de Ventas')

@section('content_header')
<h1>@yield('page_title', 'Panel')</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="icon fas fa-check"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="icon fas fa-ban"></i> {{ session('error') }}
    </div>
@endif

@if(session('alertas_stock'))
    @foreach(session('alertas_stock') as $alerta)
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-exclamation-triangle"></i> {{ $alerta }}
        </div>
    @endforeach
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="mb-3">
    <a href="{{ route('home') }}" class="btn btn-sm btn-navy">
        <i class="fas fa-home"></i> Panel Principal
    </a>
</div>

@yield('main_content')

@stop

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
@yield('extra_css')
@stop
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('extra_js')
@stack('js')
@stop