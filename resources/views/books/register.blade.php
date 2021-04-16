<h3 class="card-title">
  本を登録する
</h3>
<form action="{{ url('books/search') }}" method="POST" class="form-horizontal">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="isbn" class="col-sm-3 control-label">ISBN（13桁）</label>
      <input type="text" name="isbn" class="form-control" value="{{ old('isbn') }}">
    </div>
  </div>
  <!-- 本 検索ボタン -->
  <div class="form-row">
    <div class="col-sm-offset-3 col-sm-6">
        <button type="submit" class="btn btn-light">検索する</button>
    </div>
  </div>
</form>

<form action="{{ url('books') }}" method="POST" class="form-horizontal">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="isbn" class="col-sm-3 control-label"></label>
      @if (isset($request_book))
        <input type="hidden" name="isbn" class="form-control" value="{{ $request_book['isbn'] }}">
      @endif
    </div>
    <div class="form-group col-md-12">
      <label for="img" class="col-sm-3 control-label"></label>
      @if (isset($request_book))
        <input type="hidden" name="img" class="form-control" value="{{ $request_book['img'] }}">
      @endif
    </div>
    <div class="form-group col-md-12">
      <label for="title" class="col-sm-3 control-label">書籍名</label>
      @if (isset($request_book))
        <input name="title" class="form-control" value="{{ $request_book['title'] }}" readonly>
      @else
        <input name="title" class="form-control">
      @endif
    </div>
    <div class="form-group col-md-12">
      <label for="memo" class="col-sm-3 control-label">メモ（100字以内）</label>
      <input type="text" name="memo" class="form-control">
    </div>
  </div>
  <div class="checkbox" style="margin-left:10px">
    <label>
        <input type="checkbox" name="read[]" value="読了"> 読了済み
    </label>
  </div>
  <!-- 本 登録ボタン -->
  <div class="form-row">
    <div class="col-sm-offset-3 col-sm-6">
        <button type="submit" class="btn btn-primary">登録する</button>
    </div>
  </div>
</form>