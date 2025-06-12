{{-- resources/views/public/user/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Iniciar sesión')

   @section('content')
      <livewire:public.login-form />
      <livewire:public.register-form />
   @endsection
@endsection