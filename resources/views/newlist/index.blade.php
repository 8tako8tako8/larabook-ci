@extends('app')
@section('content')
  @include('nav')
  <div style="margin-top:20px;">
    <h2 class="px-5">新着リスト</h2>
  </div>
  @if (count($books) > 0)
    <div class="card-body">
      <table class="table table-striped task-table">
        <!-- テーブル本体 -->
        <tbody>
          @foreach ($books as $book)
            <tr>
              <td class="table-text">
                <!-- 本isbn -->
                <h5 class="pb-1">ISBN:</h5>
                <h5 class="pb-1">{{ $book->isbn }}</h5>
                <!-- 本画像 -->
                <div>
                  @if (empty($book->img) || file_exists('upload/'.$book->img))
                    <img src="upload/no_image.jpg" width="120">
                  @else
                    <img src="{{ $book->img }}" width="120">
                  @endif
                </div>
              </td>
              <td class="table-text">
                <!-- 本タイトル -->
                <div style="margin-top:20px;">
                  <h3 class="p-5">{{ $book->name }}</h3>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="row">
      <div class="col-md-4 offset-md-4">
        {{ $books->links() }}  
      </div>
    </div>
  @endif
@endsection