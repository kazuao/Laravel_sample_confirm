<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Validator;

class SampleFormController extends Controller
{
    private $formItems = ['name', 'title', 'body'];

    private $validator = [
        'name' => 'required|string|max:100',
        'title' => 'required|string|max:100',
        'body' => 'required|string|max:100',
    ];

    public function show()
    {
        return view('form');
    }

    public function post(Request $request)
    {
        $input = $request->only($this->formItems);

        // ???
        $validator = FacadesValidator::make($input, $this->validator);
        if ($validator->fails()) {
            return redirect()->action('SampleFormController@show')
                ->withInput()
                ->withErrors($validator);
        }

        // セッションに書き込む
        $request->session()->put('form_input', $input);

        return redirect()->action('SampleFormController@confirm');
    }

    public function confirm(Request $request)
    {
        // セッションから値を取り出す
        $input = $request->session()->get('form_input');

        // セッションに値がないときはフォームに戻る
        if (!$input) {
            return redirect()->action('SampleFormController@show');
        }

        return view('form_confirm', ['input' => $input]);
    }

    public function send(Request $request)
    {
        // セッションから値を取り出す
        $input = $request->session()->get('form_input');

        // 戻るボタンが押された時
        if ($request->has('back')) {
            return redirect()->action('SampleFormController@show')
                ->withInput($input);
        }

        // セッションに値がないときはフォームに戻る
        if (!$input) {
            return redirect()->action('SampleFormController@show');
        }

        // ここでメールを送信するなどの処理を行う

        // セッションを空にする
        $request->session()->forget('form_input');

        return redirect()->action('SampleFormController@complete');
    }

    public function complete()
    {
        return view('form_complete');
    }
}
