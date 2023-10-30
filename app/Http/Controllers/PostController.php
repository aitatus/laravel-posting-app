<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // 一覧ページ
    public function index() {
        // postsテーブルの全データを新しい順で取得する
        $posts = Post::latest()->get();

        // $postsをposts/index.blade.phpに渡す
        return view('posts.index', compact('posts'));
    }

    // 作成ページ
    public function create() {
        return view('posts.create');
    }

    // 作成機能
    public function store(Request $request) {
        // バリデーション
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // Postモデルをインスタンス化して新しいデータを作成
        $post = new Post();

        // フォームから送信された入力内容を各カラムに代入
        $post->title = $request->input('title');
        $post->content = $request->input('content');

        // postsテーブルにデータを保存
        $post->save();

        // 投稿一覧ページにリダイレクトさせると同時にフラッシュメッセージの内容を送信
        return redirect()->route('posts.index');
    }

    // 詳細ページ
    public function show(Post $post) {
        return view('posts.show', compact('post'));
    }

    // 更新ページ
    public function edit(Post $post) {
        return view('posts.edit', compact('post'));
    }

    // 更新機能
    // フォームから送信された内容を取得し、どのデータを更新するかという情報も必要なため、引数にRequestとPostを記述する
    public function update(Request $request, Post $post) {
        // バリデーション
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // storeアクションと違い、新しくデータを作成するのではなく、受け取ったデータを更新するためインスタンスは必要ない

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();

        // リダイレクト先を投稿詳細ページにするため、route()の第二引数にPostのモデルのインスタンスを渡す
        return redirect()->route('posts.show', $post)->with('flash_message', '投稿を編集しました。');
    }

    // 削除機能
    public function destroy(Post $post) {
        // アクション内でデータを削除するには受け取ったモデルのインスタンスに対してdelete()を実行するだけ
        $post->delete();

        // 削除後は投稿一覧ページにリダイレクトし、フラッシュメッセージが表示されるようにする
        return redirect()->route('posts.index')->with('flash_message', '投稿を削除しました。');
    }
}
