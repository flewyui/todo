<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Services\FolderService;
use App\Services\TaskService;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $folderService;
    protected $taskService;

    public function __construct(FolderService $folderService, TaskService $taskService)
    {
        $this->folderService = $folderService;
        $this->taskService = $taskService;
    }
    
    public function index(int $id)
    {
        //ユーザーの持つフォルダを取得
        $folders = Auth::user()->folders()->get();

        $currentFolder = $this->folderService->getCurrentFolder($id);

        $tasks = $this->taskService->getFolderTasks($currentFolder->id);

        return view('tasks.index', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/create
     */
    public function showCreateForm(int $id)
    {
        return view('tasks.create',[
            'folder_id' => $id
        ]);
    }

    public function create(int $id, CreateTask $request)
    {
        $currentFolder = $this->folderService->getCurrentFolder($id);

        $this->taskService->createTask($currentFolder->id, $request);

        return redirect()->route('tasks.index', [
            'id' => $currentFolder->id,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/{task_id}/edit
     */
    public function showEditForm(int $id, int $task_id)
    {
        $task = $this->taskService->getTask($task_id);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function edit(int $id, int $task_id, EditTask $request)
    {
        $task = $this->taskService->getTask($task_id);
        $this->taskService->editTask($task, $request);

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}