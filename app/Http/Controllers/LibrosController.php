<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

//使うClassを宣言：自分で追加
use App\Libro;                 // Libroモデルを使えるように
use Validator;                 // ヴァリデーションを使えるように
use Auth;                      // 認証モデルを使う

class LibrosController extends Controller{
    // コンストラクタ（最初に処理をする）
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //本ダッシュボード表示
    public function index(){
        $libros = Libro::where('user_id',Auth::user()->id)
        ->orderBy('created_at', 'asc')
        ->paginate(3);
        return view('libros',[
            'libros' => $libros
        ]);
    }

    //更新画面
    public function edit($libro_id) {
        $libros = Libro::where('user_id',Auth::user()->id)->find($libro_id);
        return view('librosedit',[
            'libro' => $libros
        ]);
    }

    //更新
    public function update(Request $request) {
    //バリデーション
    $validator = Validator::make($request->all(),[
        'id' => 'required',
        'item_name' => 'required|min:3|max:255',
        'item_number' => 'required|min:1|max:3',
        'item_amount' => 'required|max:6',
        'published' => 'required',
    ]);
    //バリデーション：エラー
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    // データ更新
    $libros = Libro::where('user_id',Auth::user()->id)->find($request->id);
    $libros->item_name = $request->item_name;
    $libros->item_number = $request->item_number;
    $libros->item_amount = $request->item_amount;
    $libros->published = $request->published;
    $libros->save();
    return redirect('/');
    }

    //登録
    public function store(Request $request) {
    //バリデーション
    $validator = Validator::make($request->all(),[
        'item_name' => 'required|min:3|max:255',
        'item_number' => 'required|min:1|max:3',
        'item_amount' => 'required|max:6',
        'published' => 'required',
    ]);

    //バリデーション：エラー
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $file = $request->file('item_img');   // file取得
    if ( !empty($file)){                  // fileが空かチェック
        $filename = $file->getClientOriginalName();    //ファイル名を取得
        $move = $file->move('../public/upload/',$filename);   //ファイルを移動
    }else{
        $filename = "";
    }

    // Eloquentモデル（登録処理）
    $libros = new Libro;
    $libros->user_id = Auth::user()->id;   //added
    $libros->item_name = $request->item_name;
    $libros->item_number = $request->item_number;
    $libros->item_amount = $request->item_amount;
    $libros->item_img = $filename;
    $libros->published = $request->published;
    $libros->save();
    return redirect('/')->with('message','本登録が完了しました');
    }

    //削除処理
    public function destroy(Libro $libro) {
        $libro->delete();
        return redirect('/');
    }
}
