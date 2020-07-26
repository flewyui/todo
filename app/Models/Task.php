<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Folder;
use Illuminate\Http\Request;

class Task extends Model
{
    const STATUS = [
        1 => ['label' => '未着手', 'class' => 'label-danger'],
        2 => ['label' => '着手中', 'class' => 'label-info'],
        3 => ['label' => '完了', 'class' => ''],
    ];

    public function getStatusLabelAttribute()
    {
        $status = $this->attributes['status'];

        if(!isset(self::STATUS[$status])){
            return '';
        }
        return self::STATUS[$status]['label'];
    }

    public function getFormattedDueDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])->format('Y/m/d');
    }

    public function getStatusClassAttribute()
    {
        $status = $this->attributes['status'];

        if(!isset(self::STATUS[$status])){
            return '';
        }
        return self::STATUS[$status]['class'];
    }

    public function getFolderTasks(int $id)
    {
        return $tasks = Folder::find($id)->tasks()->get();
    }

    public function createTask(int $id, Request $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->folder_id = $id; //フォルダーとの紐付け
        $task->due_date = $request->due_date;
        $task->save();
    }

    public function getTask(int $task_id)
    {
        return Task::find($task_id);
    }

    public function editTask(Task $task, Request $request)
    {
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();
    }
}
