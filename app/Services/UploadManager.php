<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/28
 * Time: 14:39
 */
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Dflydev\ApacheMimeTypes\PhpRepository;

 class UploadManager{
     protected $disk;
     protected $mineDetect;
     public function __construct(PhpRepository $mimeDetect)
     {
         $this->disk=Storage::disk(config('blog.uploads.storage'));
         $this->mimeDetect=$mimeDetect;
     }

     public function folderInfo($folder){
            $folder=$this->cleanFolder($folder);
            $breadcrumbs=$this->breadCrumbs($folder);
            $slice=array_slice($breadcrumbs,-1);
            $folderName=current($slice);
            $breadcrumbs=array_slice($breadcrumbs,0,-1);

            $subfolders=[];
            foreach(array_unique($this->disk->directories($folder)) as $subfolder){
                $subfolders["/$subfolder"]=basename($subfolder);
            }
            //details of all files
            $files=[];
            foreach($this->disk->files($folder) as $path){
                $files[]=$this->fileDetails($path);
            }
            return compact('folder','folderName','breadcrumbs','subfolders','files');
     }
     protected function cleanFolder($folder){
        return '/'.trim(str_replace('..','',$folder),'/');
     }
     protected function breadcrumbs($folder){
            $folder=trim($folder,'/');
            $crumbs=['/'=>'root'];
            if(empty($folder)){
                return $crumbs ;
            }
            $folders=explode('/',$folder);
            $build='';
            foreach($folders as $folder){
                $build.='/'.$folder;
                $breadcrumbs[$build]='/'.$folder;
            }
            return $breadcrumbs;
     }
     protected function fileDetails($path){
            $path='/'.ltrim($path,'/');
            return[
                'name'=>basename($path),
                'fullPath'=>$path,
                'webPath'=>$this->fileWebPath($path),
                'mimeType'=>$this->fileMimeType($path),
                'size'=>$this->fileSize($path),
                'modified'=>$this->fileModified($path)
            ];
     }

     protected function fileWebPath($path){
         $path=rtrim(config('blog.uploads.webpath'),'/').'/'.ltrim($path,'/');
         return url($path);

     }

     public function fileMimeType($path){
            return $this->mimeDetect->findType(pathinfo($path,PATHINFO_EXTENSION));
     }
     public function fileSize($path){
        return   $this->disk->size($path);
     }
     public function fileModified($path){
            return Carbon::createFromTimestamp($this->disk->size($path));
     }
     public function saveFile($path,$content){
            $path=$this->cleanFolder($path);
         if($this->disk->exists($path)){
             return 'File already exists';
         }
         return $this->disk->put($path,$content);
     }
     public function createDirectory($folder){
         $folder=$this->cleanFolder($folder);
         if($this->disk->exists($folder)) {
             return 'Folder' . $folder . ' already exists!';
         }
        return $this->disk->makeDirectory($folder);
     }
     public function deleteDirectory($folder){
         $folder = $this->cleanFolder($folder);

         $filesFolders = array_merge(
             $this->disk->directories($folder),
             $this->disk->files($folder)
         );
         if (! empty($filesFolders)) {
             return "Directory must be empty to delete it.";
         }

         return $this->disk->deleteDirectory($folder);
     }

     public function deleteFile($path){
        $file=$this->cleanFolder($path);
        if(!$this->disk->exists($file)){
            return 'file not exists!';
        }
        return $this->disk->delete($file);
     }
 }