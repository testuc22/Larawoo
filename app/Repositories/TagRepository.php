<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Tag;
use Str;
class TagRepository
{
	public function getAllTags()
	{
	    return Tag::all();
	}

	public function createTag($request)
	{
	    $request->validate([
	    	'tag_title'=>'required',
	    	'meta_title'=>'required',
	    	'content'=>'required'
	    ]);
	    Tag::create([
	    	'title'=>$request->tag_title,
	    	'metaTitle'=>$request->meta_title,
	    	'slug'=>Str::slug($request->tag_title),
	    	'content'=>$request->content
	    ]);
	    $request->session()->flash('success','Tag Created Successfully');
	    return redirect()->route('listtags');
	}

	public function getTagById($id)
	{
	    return Tag::find($id);
	}

	public function updateTag($request,$id)
	{
	    $request->validate([
	    	'tag_title'=>'required',
	    	'meta_title'=>'required',
	    	'content'=>'required'
	    ]);
	    $tag=$this->getTagById($id);
	    $tag->title=$request->tag_title;
	    $tag->metaTitle=$request->meta_title;
	    $tag->slug=Str::slug($request->tag_title);
	    $tag->content=$request->content;
	    $tag->save();
	    $request->session()->flash('success','Tag Updated Successfully');
	    return redirect()->route('listtags');
	}

	public function deleteTag($request,$id)
	{
	    $tag=$this->getTagById($id);
	    $tag->delete();
	    $request->session()->flash('success','Tag Deleted Successfully');
	    return redirect()->route('listtags');
	}
	
}