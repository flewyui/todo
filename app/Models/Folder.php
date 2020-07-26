<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Folder extends Model
{
    //このモデルはfoldersテーブルに対応することを明示
    protected $table = 'folders';

    public function getAllFolders()
    {
        return Folder::all();
    }
    
    public function getUserFolders(int $user_id)
    {
        $folders = Folder::query()
        ->select([
            'folders.id',
            'folders.title',
            'folders.created_at',
            'folders.updated_at'
        ])
        ->from('folders')
        ->where('user_id',$user_id)
        ->get();

        return $folders;
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task','folder_id','id');
    }

    public function getCurrentFolder(int $id)
    {
        return Folder::find($id);
    }

    public function createFolder(Request $request)
    {
        $folder = new Folder();
        $folder->title = $request->title;
        Auth::user()->folders()->save($folder);

        return $folder;
    }
}