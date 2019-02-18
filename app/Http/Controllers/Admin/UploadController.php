<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UploadManager;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadFolderRequest;
use Illuminate\Support\Facades\File;
class UploadController extends Controller
{
    //
    public function __construct(UploadManager $manager)
    {
        $this->manager=$manager;
    }

    public function index(Request $request){
        $folder=$request->get('folder');
        $data=$this->manager->folderInfo($folder);
        return view('admin.upload.index',$data);
    }


    public function uploadFile(UploadFileRequest $request){
            $fileName=$request->get('file_name');
            $file=$_FILES['file'];
            $fileName=$fileName??$file['name'];
            $path=str_finish($request->get('folder'),'/').$fileName;
            $content=File::get($file['tmp_name']);
            $result=$this->manager->saveFile($path,$content);
            if($request===true){
                return redirect()->back()->with('success','文件「' . $fileName . '」上传成功.');
            }
            $error=$request??'文件上传出错';
            return redirect()->back()->withErrors([$error]);


    }


    public function createFolder(UploadFolderRequest $request){
            $new_folder=$request->get('new_folder');
            $folder=$request->get('folder').'/'.$new_folder;
            $result=$this->manager->createDirectory($folder);
            if($request===true){
                return redirect()->back()->with('success','目录「' . $new_folder . '」创建成功.');
            }
            $error=$result??'创建文件夹出错';
            return redirect()->back()->withErrors([$error]);
    }

    public function deleteFile(Request $request){
            $del_file=$request->get('del_file');
            $path=$request->get('folder').'/'.$del_file;
            $result=$this->manager->deleteFile($path);
            if($result===true){
                return redirect()->back()->with('success','文件「' . $del_file . '」已删除.');
            }
            $error=$result??'删除文件出错';
            return redirect()->back()->withErrors([$error]);
    }

    public function deleteFolder(Request $request){
        $del_folder = $request->get('del_folder');
        $folder = $request->get('folder') . '/' . $del_folder;
        $result = $this->manager->deleteDirectory($folder);
        if ($result === true) {
            return redirect()
                ->back()
                ->with('success', '目录「' . $del_folder . '」已删除');
        }
        $error = $result ?: "An error occurred deleting directory.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }


}
