<?php
namespace App\Services;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderService extends Service
{
  //モデルから受け取るインスタンスを入れる箱を用意
  private $folderModel;

  //インスタンスを生成して箱に入れる。
  //これで$this->folderModelからインスタンスの持つ様々なデータやプロパティを使用できるようになる
  public function __construct(Folder $folderModel)
  {
    $this->folderModel = $folderModel;
  }

  public function getAllFolders()
  {
    return $this->folderModel->all();
  }

  public function getCurrentFolder(int $id)
  {
    return $this->folderModel->find($id);
  }

  /**
   *  DBからユーザーごとのフォルダー情報を取得
   *  @param Folderモデル
   *  @return Folderコレクション
   */ 
  public function getUserFolders(int $id)
  {
    return $this->folderModel->getUserFolders($id);
  }

  public function createFolder(Request $request)
  {
    return $this->folderModel->createFolder($request);
  }
}