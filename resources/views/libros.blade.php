<!-- resources/views/libros.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Bootstrapの定形コード -->
    <div class="card-body">
        <div class="card-title">
            本のタイトル
        </div>

        <!-- バリデーションエラーの表示に使用 -->
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用 -->

        <!-- 本のタイトル -->
        <form enctype="multipart/form-data" action="{{ url('libros') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="libro" class="col-sm-3 control-label">Book</label>
                    <input for="text" name="item_name" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label for="amount" class="col-sm-3 control-label">金額</label>
                    <input type="text" name="item_amount" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="number" class="col-sm-3 control-label">数</label>
                    <input type="text" name="item_number" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="published" class="col-sm-3 control-label">公開日</label>
                    <input type="date" name="published" class="form-control">
                </div>
            </div>
            <!-- ファイル追加 -->
            <div class="col-sm-6">
                <label>画像</label>
                <input type="file" name="item_img">
            </div>

            <!-- 本 登録ボタン -->
            <div class="form-row">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
    @if (session('message'))
        <div calss="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <!-- Libro: 既に登録されている本のリスト -->
    <!-- 現在の本 -->
    @if (count($libros) > 0)
        <div class="card-body">
            <div class="card-body">
                <table class="table table-striped task-table">
                    <!-- テーブルヘッダ -->
                    <thead>
                        <th>本一覧</th>
                        <th>&nbsp;</th>
                    </thead>
                    <!-- テーブル本体 -->
                    <tbody>
                    @foreach ($libros as $libro)
                    <tr>
                        <!-- 本タイトル -->
                        <td class="table-text">
                            <div>{{ $libro->item_name }}</div>
                            <div> <img src="upload/{{ $libro->item_img }}" width="100"></div>
                        </td>

                        <!-- 本：更新ボタン -->
                        <td>
                            <form action="{{ url('librosedit/'.$libro->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    更新
                                </button>
                            </form>
                        </td>

                        <!-- 本：削除ボタン -->
                        <td>
                            <form action="{{ url('libro/'.$libro->id) }}" method="POST">
                                @csrf                   <!-- CSRFからの保護 -->
                                @method('DELETE')       <!-- 疑似フォームメソッド -->

                                <button type="submit" class="btn btn-danger">
                                    削除
                                </button>
                        </form>
                        </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4 offset-md-4">
            {{ $libros->links() }}
        </div>
    </div>
    @endif

@endsection