<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Tag ;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Requests\PostCreateRequest;
use Carbon\Carbon;
use App\Services\PostService;

use App\Jobs\PostFormFields;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected $fieldList=[
        'title'=>'',
        'subtitle'=>'',
        'content'=>'',
        'page_image'=>'',
        'meta_description'=>'',
        'layout'=>'blog.layout.post',
        'is_draft'=>'',
        'publish_date'=>'',
        'publish_time'=>'',
        'tags'=>[]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.post.index', ['posts' => Post::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields=$this->fieldList;
        $when=Carbon::now()->addHour();
        $fields['publish_date']=$when->format('Y-m-d');
        $fields['publish_time']=$when->format('G:i A');
        foreach($this->fieldList as $fieldName=>$fieldValue){
            $fields[$fieldName]=old($fieldName,$fieldValue);
        }
        $data=array_merge($fields,['allTags'=>Tag::all()->pluck('tag')->all()]);
        return view('admin.post.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {
        $post=Post::create($request->postFillData());
        $tag=$post->syncTags($request->post('tags ',[]));
        return redirect()->route ('post.index')->with('SUCCESS','文章创建成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag=new Tag();
        $post=Post::findOrFail($id);
        $fields=$this->fieldsFromModel($id,$this->fieldList);
        foreach($fields as $fieldName=>$fieldValue){
            $fields[$fieldName]=old($fieldName,$fieldValue);
        }
        $data=array_merge($fields,['allTags'=>Tag::all()->pluck('tag')->all()]);
        return view('admin.post.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post=Post::findOrFail($id);
        $post->fill($request->postFillData());
        $res=$post->save();
        $post->syncTags($request->get('tags',[]));
        if($request->action==='continue'){
            return redirect()->back()->with('success','文章已经保存');
        }
        return redirect()->route('post.index')->with('success','文章已经保存');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $postModel=new Post();
        $post=Post::findOrFail($id);
        $post->tags()->detach();
        $post->delete();
        return redirect()->route('post.index')->with('SUCCESS','文章已删除！');
    }

    public function fieldsFromModel ($id,$fieldList){
        $post=Post::findOrFail($id);
        $fields['id']=$id;
        $fieldNames=array_keys(array_except($fieldList,'tags'));
        foreach ($fieldNames as $field ) {
            $fields[$field]=$post->{$field};
        }
        $fields['tags']=$post->tags->pluck('tags')->all();
        return $fields;
    }


}
