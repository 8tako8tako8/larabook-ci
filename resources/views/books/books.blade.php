@extends('app')
@section('content')

  @include('nav')

  <div class="card-body">

    <!-- バリデーションエラーの表示に使用-->
    @include('common.errors')

    @include('books.register')

  </div>
  
  @if (session('message'))
    <div class="alert alert-success">
      {{ session('message') }}
    </div>
  @endif

  @include('books.tundoku')

  @include('books.dokuryo')

@endsection