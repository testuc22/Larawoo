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

	public function createNewAttributeValue($request)
	{
	    $request->validate([
	    	'attribute_value.*'=>'required'
	    ]);
	    $attribute_values=$request->attribute_value;
	    $attribute_id=$request->attribute_id;
	    $data=[];
	    foreach ($attribute_values as $attribute_value) {
	        $data[]=['value'=>$attribute_value,'attribute_id'=>$attribute_id];
	    }
	    AttributeValue::insert($data);
	    $request->session()->flash('success','Attribute Values Added Successfully');
	    return redirect()->route('showattributevalues',['id'=>$attribute_id]);
	}

	public function getOneAttributeValue($id)
	{
	    return AttributeValue::find($id);
	}

	public function updateAttributeValue($request,$id)
	{
		$request->validate([
	    	'attribute_value'=>'required'
	    ]);
	    $attribute_value=$this->getOneAttributeValue($id);
	    $attribute_value->value=$request->attribute_value;
	    $attribute_value->save();
	    $attribute_id=$request->attribute_id;
	    $request->session()->flash('success','Attribute Value Updated Successfully');
	    return redirect()->route('showattributevalues',['id'=>$attribute_id]);

	}

	public function deleteAttributeValue($request,$id,$atrid)
	{
	    $attribute_value=$this->getOneAttributeValue($atrid);
	    $attribute_value->delete();
	    $request->session()->flash('success','Attribute Value Deleted Successfully');
	    return redirect()->route('showattributevalues',['id'=>$id]);
	}
}