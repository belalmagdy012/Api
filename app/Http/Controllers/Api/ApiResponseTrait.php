<?php
namespace App\Http\Controllers\Api;

trait ApiResponseTrait
{

    public function apiResponse($data= null , $mesg = null,$status=null){

        $arry=[
            $data = $data,
            $mesg = $mesg,
            $status = $status
        ];
        return response( $arry,$status);


    }
}
