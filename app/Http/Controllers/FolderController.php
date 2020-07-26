<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use App\Services\FolderService;
use App\Http\Requests\CreateFolder;

class FolderController extends Controller
{
    protected $folderService;

    public function __construct(FolderService $folderService)
    {
        $this->folderService = $folderService;
    }

    public function showCreateForm()
    {
        return view('folders/create');
    }

    public function create(CreateFolder $request)
    {
        $folder = $this->folderService->createFolder($request);

        return redirect()->route('tasks.index',[
            'id' => $folder->id,
        ]);
    }
}
    