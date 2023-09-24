<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\ApiResponseTrait;
use App\Traits\GeneralTrait;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CtegoryController extends Controller
{
    //use ApiResponseTrait;
    use GeneralTrait;
    public function index()
    {
        /*$categories =CategoryResource::collection(Category::get());
        return $categories;*/
        //return $this->apiResponse($categories,'ok',200);
        $categories = Category::select('id','name_'.app()->getLocale() .' as name')->get();
        return $this->returnData('categories',$categories);

    }

    public function getCategoryById(Request $request)
    {

        $category = Category::select('id','name_'.app()->getLocale() .' as name')->find($request->id);

        if(!$category)
          return $this->returnError('001','هذا القسم غير موجود');
        return $this->returnData('category',$category,'تم جلب الببانات بنجاح');

    }

    public function changeStatus(Request $request)
    {
        Category::where('id',$request->id)->update(['active'=>$request->active]);
        return $this->returnSuccessMessage('تم تغيير الحاله بنجاح');
    }











    public function show($id)
    {

        $categories =Category::find($id);

        if($categories){
            return $this->apiResponse( new CategoryResource($categories),'ok',200);
        }
        return $this->apiResponse(null,'the item not found ',401);

        }


        public function store(Request $request)
        {

           $validate= Validator::make($request->all(), [
                'name_ar' => 'required|max:255',
                'name_en' =>'required',
            ]);
            if($validate->fails())
            {
                return $this->apiResponse(null,$validate->errors(),400);

            }


            $category = Category::create($request->all());
            if($category){
                return $this->apiResponse( new CategoryResource($category),'the category save',200);
            }
            return $this->apiResponse(null,'the item not save ',400);



        }



        public function update(Request $request,$id)
        {

           $validate= Validator::make($request->all(), [
                'name_ar' => 'required|max:255',
                'name_en' =>'required',
            ]);
            if($validate->fails())
            {
                return $this->apiResponse(null,$validate->errors(),400);

            }

            $category = Category::find($id);
            if(!$category){
                return $this->apiResponse(null,'the item not found ',400);
            }

            $category->update($request->all());

            if($category){
                return $this->apiResponse( new CategoryResource($category),'the category save',200);
            }
            return $this->apiResponse(null,'the item not updated ',400);



        }

        public function destroy($id)
        {
            $category = Category::find($id);
            if(!$category){
                return $this->apiResponse(null,'the item not found ',400);
            }
            $category->delete();
            if($category){
                return $this->apiResponse(null,'the item deleted ',200);
            }


        }

















}
