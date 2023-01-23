# 概要
書籍管理アプリ。積ん読している本を管理できる。

![book](https://user-images.githubusercontent.com/65395999/115192591-fa4acc80-a125-11eb-9f9a-18acbfee1903.gif)

# 主な機能(わたしの本棚)
- 書籍検索機能
    - ISBNコードを入力するとopenBD(書籍検索API)から本情報を取得できる
- 手入力機能
    - 本を検索せずに直接書籍名を入力できる
- 積読・読了切替機能
    - 積読リストか読了リストに加えるためのチェックボックスあり
- メモ機能
    - 登録する本にメモを加えることができる
- 編集機能
    - 編集画面で積読から読了済みの変更、メモの変更ができる
- 画像アップロード機能
    - 書籍の画像がない場合、編集画面で自分でアップロードできる

# その他の機能
- みんなの本棚
    - ユーザーが登録した本の新着リストが見れる。(ページネーション機能付き)
- 新規登録・ログイン・ログアウト機能
<br>
<img width="849" alt="book" src="https://user-images.githubusercontent.com/65395999/115203337-4f8cdb00-a132-11eb-8712-f4e4c316375a.png">

# 技術
- PHP 7.3.27
- Laravel 6.12.0
- MDBootstrap
- PostgreSQL 11.10
- AWS
    - EC2へデプロイ
    - Route53でDNSレコードを管理
    - ACMでSSL証明書を管理、ALBで使用

# 開発環境
- Laradock, Docker-compose
- CircleCI
