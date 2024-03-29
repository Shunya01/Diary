<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
use App\Http\Requests\CreateDiary; // 追加
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    public function index()
    {

//::でメソッドを呼んでいるのはLaravelのファサードという機能の一つ
     //order by,get->クエリビルダ
     //eloquentもクエリビルダもDBを操作する機能
    $diaries = Diary::with('likes')->orderBy('id', 'desc')->get();


        // $diaries = Diary::all();
        //allはテーブルの中身を全て取得する


        // dd($diaries);
        //dd->die and dump
        //var_dumpとexitをまとめて実行してくれる関数

        //viewsディレクトリの中のdiariesディレクトリの中のindex(.blade).phpを返す
        //第二引数に連想配列の形でviewで使用したいデータをかく
        //key=viewで使用する変数名、valueが実際の変数
        return view('diaries.index',['diaries' => $diaries]);

    }

    public function create(){
        // views/diaries/create.blade.phpを表示する
        return view('diaries.create');
    }



    public function store(CreateDiary $request)
    {
        $diary = new Diary(); //Diaryモデルをインスタンス化

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->user_id = Auth::user()->id; //追加 ログインしてるユーザーのidを保存
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }

    //引数の変数名はなんでもOK
    //引数はルートのワイルドカードに入っている値


    public function destroy(Diary $diary){
         //Diaryモデルを使用して、diariesテーブルから$idと一致するidをもつデータを取得
        if (Auth::user()->id !== $diary->user_id) {
    abort(403);
}

    //取得したデータを削除
    $diary->delete();

    return redirect()->route('diary.index');
    }

    public function edit(Diary $diary)
    {
        if (Auth::user()->id !== $diary->user_id) {
    abort(403);
    }

    return view('diaries.edit', [
        'diary' => $diary,
    ]);
    }

    public function update(Diary $diary, CreateDiary $request)
{
    if (Auth::user()->id !== $diary->user_id) {
    abort(403);
}

    $diary->title = $request->title; //画面で入力されたタイトルを代入
    $diary->body = $request->body; //画面で入力された本文を代入
    $diary->save(); //DBに保存

    return redirect()->route('diary.index'); //一覧ページにリダイレクト
}

    public function like(int $id)
{
    $diary = Diary::where('id', $id)->with('likes')->first();

    $diary->likes()->attach(Auth::user()->id);
}

    public function dislike(int $id)
{
    $diary = Diary::where('id', $id)->with('likes')->first();

    $diary->likes()->detach(Auth::user()->id);
}

}
