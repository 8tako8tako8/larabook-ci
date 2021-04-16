<!-- 読了リスト -->
@if (isset($books))
  @if (count($books) > 0)
    <div class="card-body">
      <table class="table table-striped task-table">
        <!-- テーブルヘッダ -->
        <thead>
          <th><h3>読了リスト</h3></th>
          <th>&nbsp;</th>
        </thead>
        <!-- テーブル本体 -->
        <tbody>
          @foreach ($books as $book)
            @if ($book->read == true)
              <tr>
                <td class="table-text">
                  <!-- 本画像 -->
                  <div>
                    @if (empty($book->img))
                      <img src="{{ asset('upload/no_image.jpg') }}" width="100">
                    @elseif (file_exists('upload/'.$book->img))
                      <img src="{{ 'upload/'.$book->img }}" width="100">
                    @else
                      <img src="{{ $book->img }}" width="100">
                    @endif
                  </div>
                </td>
                <td class="table-text">
                  <!-- 本タイトル -->
                  <div style="width:600px;margin-top:20px;">
                    <h4>{{ $book->name }}</h4>
                  </div>
                  <!-- メモ -->
                  <div style="width:500px;margin-top:20px;">
                    @if (!empty($book->memo))
                      <h5>メモ：</h5>
                      <h5>{{ $book->memo }}</h5>
                    @endif
                  </div>
                </td>
                <td>
                  <form action="{{ url('booksedit/'.$book->id) }}" method="POST">
                    @csrf
                    <!-- 本: 更新ボタン -->
                    <div style="margin-top:7px;margin-bottom:5px;">
                      <button type="submit" class="btn btn-primary">編集</button>
                    </div>
                  </form>
                  </br>
                  <form action="{{ url('book/'.$book->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- 本: 削除ボタン -->
                    <div style="margin-top:5px;margin-bottom:7px;">
                      <button type="submit" class="btn btn-danger">削除</button>
                    </div>
                  </form>
                </td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@endif