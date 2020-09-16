@extends('layouts.app')

@section('content')

<div class="container">


{{--  enctype='multipart/form-data es un tipo de codificación que permite enviar archivos a través dePOST  --}}
<form action="{{ url('/empleados/' .$empleado->id) }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
{{ method_field('PATCH') }}{{--  Envia el metodo update al registro--}}
@include('empleados.form',['Modo'=>'editar'])
</form>


</div>
@endsection
