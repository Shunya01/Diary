<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;

class DiaryController extends Controller
{
    public function index()
    {


        $diaries = Diary::all();
        //allはテーブルの中身を全て取得する

        // dd($diaries);
        //dd->die and dump
        //var_dumpとexitをまとめて実行してくれる関数

        //viewsディレクトリの中のdiariesディレクトリの中のindex(.blade).phpを返す
        //第二引数に連想配列の形で
        return view('diaries.index',['diaries' => $diaries]);

    }
}
