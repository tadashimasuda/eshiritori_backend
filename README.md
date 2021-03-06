### Backend
frontend( [github]:https://github.com/tadashimasuda/eshiritori_frontend )

## 作った理由
   - Twitterカード（OGP）を使ったサービスを開発したかったため。
   - 個人的にも使ってみたい技術が存在したため（Twitter連携、お絵かき機能Canvas).

## アプリ概要
   ツイッター上で絵しりとりができるサービス
1. ツイートで指定されたユーザーはアプリにアクセス
2. NuxtからLaravelのAPIを実行
3. AWS S3への投稿（描画された絵）された画像の保存
4. Twitter API(OAuth)によってユーザー情報の取得（Laravel Socialite)
5. Twitter APIからユーザーのフォロワー取得
6. 設置済みのツイートリンクからツイート

<img src="https://user-images.githubusercontent.com/51233312/117447425-7b082600-af78-11eb-8969-79dfd9b8b9e5.png" width="500px">
<img src="https://user-images.githubusercontent.com/51233312/120349355-033fd800-c339-11eb-834e-426b67463246.png" width="500px">

## 注力した点(Backend)
- インフラにAWSを用いた。
    - EC2,RDS,VPCを用いてbackendをデプロイに挑戦した。
- N+1の解決
   - 無駄なSQLの発行を改善した。
- 認可機能の実装
   - テーブルの更新を権限のあるユーザのみ実行できるようにした。
- AWS S3を用いた画像アップロード、トランザクション処理　
   - base64でデコードした画像をAWS S3にアップロードする際にDBの一貫性が失われないようにトランザクション処理を用いた。
## 機能
- ログイン機能
- 新規登録機能
- ユーザー情報編集機能
- ユーザー詳細（プロフィール、投稿した絵、主催したテーブル）
- ユーザー一覧（画家一覧）
- テーブル作成機能
- テーブル閉鎖機能（編集）
- テーブル一覧
- テーブル詳細
- 絵コンテンツ投稿機能

## 使用した言語、技術、サービス
- 言語
    - Frontend : Nuxt.js
    - Backend : Laravel

- DB
    - Mysql

- 技術
    - 認証周り
        Laravel　Socialite,Passport
    
    - Cors
        laravel-cors
    
    - フォロワー取得
        abraham/twitteroauth(Twitter API)

- サービス
    - ストレージサービス
        AWS S3
        
## 実装予定
- いいね機能、お気に入り機能、通知機能
