<?php

namespace App\Model;

use App\Services\Markdowner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Post extends Model
{
    protected $fillable=[
        'title','subtitle','content_raw','page_image',
        'meta_description','layout','publish_at'
    ];
    public function __construct(array $attributes = [])
    {

        parent::__construct($attributes);
    }

    protected $dates=['publish_at'];

    public function setTitleAttribute($value){
        $this->attributes['title']=$value;
        if(!$this->exists){
            $value=uniqid(str_random(8));
            $this->setUniqueSlug($value,0);
        }
    }

    /***
     * many to many relation
     * @return BelongsToMany
     * @author WuJiahui <cpt.matrix@hotmail.com>
     * @date 2019/2/15 15:55
     */
    public function tags(){
        return $this->belongsToMany(Tag::class,'post_tag_pivot');
    }

    protected function setUniqueSlug($title,$extra){
            $slug=str_slug($title.'-'.$extra);
            if(static::where('slug',$slug)->exists()){
               $this->setUniqueSlug($title,$extra+1);
               return;
            }
            $this->attributes['Slug']=$slug;
    }

    public function setContentRawAttribute($value){
        $markdowner=new Markdowner();
        $this->attributes['content_raw']=$value;
        $this->attributes['content_html']=$markdowner->toHtml($value);
    }

    public function syncTags(array $tags){
        Tag::addNeededTags($tags);
        if(count($tags)){
            $this->tags()->sync(Tag::whereIn('tag',$tags)->get()->pluck('id')->all());
            return;
        }
        $this->tags()->detach();
    }

    public function getPublishDateAttribute($value){
        return $this->publish_at->format('Y-m-d');
    }

    public function getPublishTimeAttribute($value){
        return $this->publish_at->format('g:i A');
    }

    public function getContentAttribute($value){
        return $this->content_raw;
    }

    public function newerPost($tag){
        $query=static::where('publish_at','>',$this->publish_at)->
            where('publish_at','<=',Carbon::now())->
            where('is_draft',0)->
            orderBy('publish_at','desc');
        if($tag){
            $post=$query->whereHas('tags',function($q)use($tag){
               $q->where('tag','=',$tag->tag);
            });
        }
        return $post->first();
    }

    public function olderPost($tag){
        $query=static::where('publish_at','<',$this->publish_at)->
            where('is_draft',0)->
            orderBy('publish_at','desc');
        if($tag){
            $post=$query->whereHas('tags',function($q)use($tag){
                $q->where('tag','=',$tag->tag);
            }
            );
        }
        return $post->first();
    }

    public function url(Tag $tag=null){
        $url=url('blog/'.$this->slug);
        if($tag){
            $url.='?tag='.urlencode($tag->tag);
        }
        return $url;
    }

    public function TagLinks($base='/blog/%TAG%'){
        $tags=$this->tags()->pluck('tag')->all();
        foreach ($tags as $index=>$tag) {
            $url=str_replace('%TAG%',urlencode($tag),$base);
            $return[]='<a href="'.$url.'">'.e($tag).'</a>';
        }
        return $return;
    }
}

