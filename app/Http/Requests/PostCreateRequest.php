<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
class PostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required',
            'subtitle'=>'required',
            'content'=>'required',
            'publish_time'=>'required',
            'publish_date'=>'required',
            'layout'=>'required'
        ];
    }

    public function postFillData(){
        $publish_at=new Carbon($this->publish_date.''.$this->publish_time);
        return [
            'title'=>$this->title,
            'subtitle'=>$this->subtitle,
            'content_raw'=>$this->get('content'),
            'meta_description'=>$this->meta_description,
            'page_image'=>$this->page_image,
            'layout'=>$this->layout,
            'is_draft'=>$this->is_draft,
            'publish_at'=>$publish_at
        ];
    }
}
