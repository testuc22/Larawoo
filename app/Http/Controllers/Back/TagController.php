<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TagRepository;
class TagController extends Controller
{
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository=$tagRepository;
    }

    public function getAllTags()
    {
        $tags=$this->tagRepository->getAllTags();
        return view('back/tags/list')->with(['tags'=>$tags]);
    }

    public function getCreateTagPage()
    {
        return view('back/tags/create');
    }

    public function createTag(Request $request)
    {
        $result=$this->tagRepository->createTag($request);
        return $result;
    }

    public function getEditTagPage($id)
    {
        $tag=$this->tagRepository->getTagById($id);
        return view('back/tags/edit')->with(['tag'=>$tag]);
    }

    public function updateTag(Request $request,$id)
    {
        $result=$this->tagRepository->updateTag($request,$id);
        return $result;
    }

    public function deleteTag(Request $request,$id)
    {
        $result=$this->tagRepository->deleteTag($request,$id);
        return $result;
    }
}
