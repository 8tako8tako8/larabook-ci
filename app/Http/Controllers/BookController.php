<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Book;   //Bookモデルを使えるようにする
use Validator;  //バリデーションを使えるようにする
use Auth;       //認証モデルを使用する

class BookController extends Controller
{
    //コンストラクタ （このクラスが呼ばれたら最初に処理をする）
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 登録画面・ダッシュボード表示
     */
    public function index() {
        $books = Book::where('user_id',Auth::user()->id)->orderBy('updated_at', 'desc')->get();
        return view('books.books', ['books' => $books]);
    }

    /**
     * 更新画面
     */
    public function edit($book_id){
        $books = Book::where('user_id',Auth::user()->id)->find($book_id);
        return view('books.booksedit', ['book' => $books]);
    }

    /**
     * 更新処理
     */
    public function update(Request $request) {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'memo' => 'max:100',
            'img' => 'mimes:jpeg,png'
        ]); 
        //バリデーション:エラー 
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $file = $request->file('img');
        if (!empty($file)) {
            $filename = $file->getClientOriginalName();
            $move = $file->move('../public/upload/', $filename);
        } else {
            $filename = NULL;
        }

        //データ更新
        $books = Book::where('user_id', Auth::user()->id)->find($request->id);
        $books->memo = $request->memo;
        if (!empty($filename))
            $books->img = $filename;
        if (isset($request->read) && is_array($request->read)) {
            $books->read = true;
        } else {
            $books->read = false;
        }
        $books->save();
        return redirect('/');
    }

    /**
     * 本検索
     */
    public function search(Request $request)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'isbn' => 'required'
        ]);
        //バリデーション:エラー 
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $request_book = $this->getBookInfo($request->isbn);
        $books = Book::where('user_id',Auth::user()->id)->orderBy('updated_at', 'desc')->get();
        return view('books.books', ['request_book' => $request_book, 'books' => $books]);
    }

    public function getBookInfo($isbn)
    {
        //ISBNが13桁の数字か確認
        if (mb_strlen($isbn) != 13 || ctype_digit($isbn) == false) {
            $is_valid = false;
        } else {
            $is_valid = true;
        }
        //カスタムバリデーション
        $validator = Validator::make(['isbn' => $is_valid], ['isbn' => 'accepted'], ['ISBNコードは13桁の数字で入力してください']);
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $registered_book = Book::where('user_id', Auth::user()->id)->where('isbn', $isbn)->first();
        if ($registered_book !== NULL) {
            $is_unregistered = false;
        } else {
            $is_unregistered = true;
        }
        //カスタムバリデーション
        $validator = Validator::make(['isbn' => $is_unregistered], ['isbn' => 'accepted'], ['この書籍は登録済みです。']);
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        //API取得
        $base_url = 'https://api.openbd.jp/v1/get?isbn=';
        $response = file_get_contents($base_url.$isbn);
        $result = json_decode($response, true);

        if ($result[0] == null) {
            $is_available = false;
        } else {
            $is_available = true;
        }
        //カスタムバリデーション
        $validator = Validator::make(['isbn' => $is_available], ['isbn' => 'accepted'], ['該当するISBNコードは見つかりませんでした。']);
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $title = $result[0]["summary"]["title"];
        $img = $result[0]["summary"]["cover"];
        $book = [
          'title' => $title,
          'isbn' => $isbn,
          'img' => $img
        ];
        return $book;
    }

    /**
     * 登録処理
     */
    public function store(Request $request) {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'memo' => 'max:100',
        ]);
        //バリデーション:エラー 
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        // Eloquentモデル（登録処理）
        $books = new Book;
        $books->user_id  = Auth::user()->id;
        $books->isbn = $request->isbn;
        $books->name = $request->title;
        $books->memo = $request->memo;
        $books->img = $request->img;
        if (isset($request->read) && is_array($request->read)) {
            $books->read = true;
        } else {
            $books->read = false;
        }
        $books->save();
        return redirect('/')->with('message', '本登録が完了しました');
    }

    /**
     * 削除処理
     */
    public function destroy(Book $book) {
        $book->delete();
        return redirect('/');
    }
}
