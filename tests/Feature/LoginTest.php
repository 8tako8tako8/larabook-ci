<?php

namespace Tests\Feature;

use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン画面を表示
     */
    public function testLoginView()
    {
        $response = $this->get(route('login'));
        
        $response->assertStatus(200);
        $this->assertGuest();
    }

    /**
     * ログイン処理を実行
     */
    public function testLogin()
    {
        $this->assertGuest();

        $response = $this->dummyLogin();
        $response->assertStatus(200)
            ->assertViewIs('books.books');
        $this->assertAuthenticated();
    }

    /**
     * ログアウト処理を実行
     */
    public function testLogout()
    {
        $response = $this->dummyLogin();
        $this->assertAuthenticated();

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('books.index'));
        $this->assertGuest();
    }

    /**
     * ダミーユーザーログイン
     */
    private function dummyLogin()
    {
        $user = factory(User::class)->create();
        return $this->actingAs($user)
                    ->withSession(['user_id' => $user->id])
                    ->get(route('books.index'));
    }

    /**
     *　非ログイン状態で個人の本棚へアクセス(ログイン画面へアクセス)
     */
    public function testGuestIndex()
    {
        $response = $this->get(route('books.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * ログイン状態で個人の本棚へアクセス
     */
    public function testAuthIndex()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('books.index'));

        $response->assertStatus(200)
            ->assertViewIs('books.books');
    }
}
