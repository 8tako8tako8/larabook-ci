<?php

namespace Tests\Feature;

use App\Book;
use App\Http\Controllers\BookController;
use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * APIで検索し、その本を登録する
     */
/*     public function testRegisterBook()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('books.index'));

        $BookController = new BookController;
        $tmp_book = $BookController->getBookInfo('9784822283117');
        $title = $tmp_book['title'];
        $isbn = $tmp_book['isbn'];
        $img = $tmp_book['img'];
        $book = [
            'title' => $title,
            'isbn' => $isbn,
            'img' => $img,
        ];
        $this->post(route('books.search'), $book)
            ->assertSee('書籍名')
            ->assertSee('ネットワークはなぜつながるのか : 知っておきたいTCP/IP、LAN、光ファイバの基礎知識');

        $this->post(route('books.store'), $book);

        $this->assertDatabaseHas('books', [
            'isbn' => '9784822283117',
            'name' => 'ネットワークはなぜつながるのか : 知っておきたいTCP/IP、LAN、光ファイバの基礎知識',
            'img' => 'https://cover.openbd.jp/9784822283117.jpg',
            'read' => false
        ]);

        $this->get(route('books.index'))
            ->assertSee('ネットワークはなぜつながるのか : 知っておきたいTCP/IP、LAN、光ファイバの基礎知識');
    } */

    /**
     * APIで検索し、読了済みにチェックして登録する
     */
/*     public function testRegisterBookWithRead()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('books.index'));

        $BookController = new BookController;
        $tmp_book = $BookController->getBookInfo('9784822283117');
        $title = $tmp_book['title'];
        $isbn = $tmp_book['isbn'];
        $img = $tmp_book['img'];
        $read = array('読了');
        $book = [
            'title' => $title,
            'isbn' => $isbn,
            'img' => $img,
            'read' => $read
        ];
        $this->post(route('books.search'), $book)
            ->assertSee('書籍名')
            ->assertSee('ネットワークはなぜつながるのか : 知っておきたいTCP/IP、LAN、光ファイバの基礎知識');

        $this->post(route('books.store'), $book);

        $this->assertDatabaseHas('books', [
            'isbn' => '9784822283117',
            'name' => 'ネットワークはなぜつながるのか : 知っておきたいTCP/IP、LAN、光ファイバの基礎知識',
            'img' => 'https://cover.openbd.jp/9784822283117.jpg',
            'read' => true
        ]);

        $this->get(route('books.index'))
            ->assertSee('ネットワークはなぜつながるのか : 知っておきたいTCP/IP、LAN、光ファイバの基礎知識');

    } */

    /**
     * 本を検索せずに登録する
     */
    public function testRegisterBookWithoutSearch()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('books.index'));

        $book = [
            'title' => 'ハリーポッター',
            'isbn' => NULL,
            'img' => NULL,
            'memo' => '面白い',
        ];

        $this->post(route('books.store'), $book);

        $this->assertDatabaseHas('books', [
            'isbn' => NULL,
            'name' => 'ハリーポッター',
            'img' => NULL,
            'memo' => '面白い'
        ]);

        $this->get(route('books.index'))
            ->assertSee('ハリーポッター');
    }
}
