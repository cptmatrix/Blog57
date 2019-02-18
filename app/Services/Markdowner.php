<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/4
 * Time: 11:40
 */

namespace App\Services;
use Michelf\MarkdownExtra;
use Michelf\SmartyPants;

class Markdowner
{
    public function toHtml($text){
        $text=$this->preTransformText($text);
        $text=MarkdownExtra::defaultTransform($text);
        $text=SmartyPants::defaultTransform($text);
        $text=$this->postTransformText($text);
        return $text;
    }
    protected function preTransformText($text){
        return $text;
    }
    protected function postTransformText($text){
        return $text;
}

}