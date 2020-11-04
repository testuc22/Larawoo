<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\{
	Attribute,
	AttributeValue
};

class AttributeRepository
{
	
	public function getAllAttributes()
	{
	    return Attribute::all();
	}

	public function getOneAttribute($id)
	{
	    return Attribute::find($id);
	}

	public function createNewAttribute($request)
	{
	    $request->validate([
	    	'attribute_name'=>'required'
	    ]);

	    Attribute::create([
	    	'name'=>$request->attribute_name
	    ]);
	    $request->session()->flash('success','Attribute Created Successfully');
	    return redirect()->route('listattributes');
	}

	public function updateAttribute($request,$id)
	{
	    $request->validate([
	    	'attribute_name'=>'required'
	    ]);
	    $attribute=$this->getOneAttribute($id);
	    $attribute->name=$request->attribute_name;
	    $attribute->save();
	    $request->session()->flash('success','Attribute Updated Successfully');
	    return redirect()->route('listattributes');
	}

	public function deleteAttribute($request,$id)
	{
	    $attribute=$this->getOneAttribute($id);
	    $attribute->delete();
	    $request->session()->flash('success','Attribute Deleted Successfully');
	    return redirect()->route('listattributes');
	}

	public function getAllAttributeValuesById($id)
	{
	    return AttributeValue::where('attribute_id','=',$id)->get();
	}
}