<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AttributeRepository;
class AttributeController extends Controller
{
    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository=$attributeRepository;
    }

    public function getAllAttributes()
    {
    	$attributes=$this->attributeRepository->getAllAttributes();
        return view('back/attributes/list')->with(['attributes'=>$attributes]);
    }

    public function getCreateAttributePage()
    {
        return view('back/attributes/create');
    }

    public function createNewAttribute(Request $request)
    {
        $result=$this->attributeRepository->createNewAttribute($request);
        return $result;
    }

    public function getEditAttributePage(Request $request,$id)
    {
        $attribute=$this->attributeRepository->getOneAttribute($id);
        return view('back/attributes/edit')->with(['attribute'=>$attribute]);
    }

    public function updateAttribute(Request $request,$id)
    {
        $result=$this->attributeRepository->updateAttribute($request,$id);
        return $result;
    }

    public function deleteAttribute(Request $request,$id)
    {
        $result=$this->attributeRepository->deleteAttribute($request,$id);
        return $result;
    }

    public function getAllAttributeValuesById(Request $request,$id)
    {
        $attributeValues=$this->attributeRepository->getAllAttributeValuesById($id);
        return view('back/attributes/show')->with(['attributeValues'=>$attributeValues,'id'=>$id]);
    }

    public function getCreateAttributeValuePage($id)
    {
        return view('back/attributevalues/create')->with(['id'=>$id]);
    }

    public function createNewAttributeValue(Request $request)
    {
        $result=$this->attributeRepository->createNewAttributeValue($request);
        return $result;
    }

    public function getEditAttributeValuePage(Request $request,$id,$atrid)
    {
        $attributeValue=$this->attributeRepository->getOneAttributeValue($atrid);
        return view('back/attributevalues/edit')->with(['attributeValue'=>$attributeValue,'id'=>$id]);
    }

    public function updateAttributeValue(Request $request,$id)
    {
        $result=$this->attributeRepository->updateAttributeValue($request,$id);
        return $result;
    }

    public function deleteAttributeValue(Request $request,$id,$atrid)
    {
        $result=$this->attributeRepository->deleteAttributeValue($request,$id,$atrid);
        return $result;
    }
}
