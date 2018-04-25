<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\Contracts\DataTable;

class DataController extends Controller{



  public function product(Request $Request){
    return datatables()->eloquent(User::query())->toJson();
  }
//    $page = empty($Request->draw)?1:$Request->draw;
//    $length = empty($Request->draw)?10:$Request->length;
//    $lisst = User:: paginate($length, ['*'], 'draw', $page )->toArray();
//
//
// $dataNew = [];
//  foreach ($lisst['data'] as $key => $value) {
//  $dataNew[] = ['id'=>($key+1),'name'=>$value['name'],'email'=>$value['email'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
//  }
//      $data = [
//      'draw'=>$page,
//      'recordsTotal'=>$lisst['total'],
//      'recordsFiltered'=>$lisst['last_page'],
//      'data'=>$dataNew
//    ];
//
//    return json_encode($data);
//
//  }
  public function deleteUser(Request $Request){
    $id= (int)$Request->id;
    $OneUser = User::find($id);
    if(empty($OneUser)){return;}
    $OneUser->delete();
    return json_encode(true);

  }


  public function editPostUser(Request $Request){
   $id = (int)$Request->id;
   $OneUser = User::find($id);
   if(empty($OneUser)){return;}

  //Bác làm rùi làm lun học hỏi lun đc k bác. 
   $OneUser->name = $Request->userName;
  
   $OneUser->updated_at = time();
   $OneUser->save();
   return json_encode(['id'=>$OneUser->id,'email'=>$OneUser->email,'name'=>$OneUser->name,'updated_at'=>date('Y:m-d H:i:s')]);
 }


 public function Create(Request $Request){
      $dateCreate=date('Y:m-d H:i:s');
        $arData=array(
          'name'=>trim($Request->userName),
          'email'=>$Request->userEmail,
            'password'=>trim(bcrypt($Request->userPassword)),
            'created_at'=>$dateCreate
        );
       $ok= User::insert($arData);
        return json_encode($ok);

 }
 public function CheckEmail(Request $Request){
     $email = $Request->userEmail;
     $count = User::select('email')->whereEmail($Request->userEmail)->count();
     if($count >0){
         return json_encode(false);
     }else{
         return json_encode(true);
     }

 }
}


