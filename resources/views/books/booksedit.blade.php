@extends('app')
@section('content')

  @include('nav')

  <div class="row container">  
    <div class="col-md-12">
      @include('common.errors')
      <form enctype="multipart/form-data" action="{{ url('books/update') }}" method="POST">
        <div class="form-group" style="margin-top:10px">
          <label for="isbn">ISBN(13桁)</label>
          <div>{{$book->isbn}}</div>
        </div>

        <div class="form-group">
          <label for="name">書籍名</label>
          <div>{{$book->name}}</div>
        </div>

        <div>
          @if (empty($book->img))
            <img src="{{ asset('upload/no_image.jpg') }}" width="150">
            <div>
              <label>画像</label>
              <input type="file" name="img" accept="image/png, image/jpeg">
            </div>
          @elseif (file_exists('upload/'.$book->img))
            <img src="{{ asset('upload/'.$book->img) }}" width="150">
            <div>
              <label>画像</label>
              <input type="file" name="img" accept="image/png, image/jpeg">
            </div>
          @else
            <img src="{{ $book->img }}" width="150">
          @endif
        </div>
        <div class="form-group" style="margin-top:20px;">
          <label for="memo">メモ(100字以内)</label>
          <input type="text" name="memo" class="form-control" value="{{$book->memo}}">
        </div>

        <div class="form-group">
          <label for="read"></label>
          @if ($book->read == true)
            <input type="checkbox" name="read[]" value="読了" checked>読了済み
          @else
            <input type="checkbox" name="read[]" value="読了">読了済み
          @endif
        </div>
                
        <!-- Saveボタン/Backボタン -->
        <div class="well well-sm">
          <button type="submit" class="btn btn-primary">保存する</button>
          <a class="btn btn-link pull-right" href="{{ url('/') }}">戻る</a>
        </div>
         
        <!-- id値を送信 -->
        <input type="hidden" name="id" value="{{$book->id}}">
          <!-- CSRF -->
          @csrf 
      </form>
    </div>
  </div>
@endsection