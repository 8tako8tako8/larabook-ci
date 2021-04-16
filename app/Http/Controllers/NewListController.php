<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Book;   //Bookモデルを使えるようにする

class NewListController extends Controller
{
    //新着リストを表示
    public function index() {
        $books = Book::whereNotNull('isbn')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
        return view('newlist.index', ['books' => $books]);
    }

}
