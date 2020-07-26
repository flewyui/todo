<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Validation\Rule;

class EditTask extends CreateTask
{
    public function rules()
    {
        $rule = parent::rules();
        //入力値が許可リストに含まれているか検証するinルールを使用。
        $status_rule = Rule::in(array_keys(Task::STATUS)); //許可リストはarray_keys(Task::STATUS)で配列として取得できるので、Ruleクラスのinメソッドを使ってルールの文字列を作成。

        return $rule + [
            'status' => 'required|' . $status_rule, //結果として出力されるルールは 'status' => 'required|in(1, 2, 3)' ,
        ];
    }

    public function attributes()
    {
        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態', //親クラスCreateTaskのattributesメソッドの結果と合体。
        ];
    }

    public function massages()
    {
        $message = parent::messages();

        $status_labels = array_map(function ($item) {
            return $item['label'];
        }, Task::STATUS);

        $status_labels = implode('、', $status_labels);

        return $messages + [
            'status.in' => ':attributeには' . $status_labels . 'のいずれかを指定してください。'
        ];
    }
}
