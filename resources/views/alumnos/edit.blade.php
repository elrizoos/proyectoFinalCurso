

@extends('layouts.app', ['modo'=>'Editando alumno'])

@section('content')
<header>
    <h1>Editar de Alumno</h1>
</header>
<div class="container">
    
    <form class="row" action="{{url('/alumnos/'.$alumno->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    {{method_field('PATCH')}}
    @include('alumnos.form', ['modo'=>'Editar'])
</form>
</div>
@endsection