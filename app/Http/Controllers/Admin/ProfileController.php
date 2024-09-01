<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profile;

class ProfileController extends Controller
{
    //
    public function add()
    {
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
        return redirect('admin/profile/create');
    }
    
    public function edit(Request $request)
    {
        return view('admin.profile.edit');
    }
    
    public function update(Request $request)
    {
        // Validationを行う
        $this->validate($request, Profile::$rules);
    
        $profile = new Profile;
        // 送信されてきたフォームデータを格納
        $form = $request->all();
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        
        // 該当するデータを上書き保存
        $profile->fill($form);
        $profile->save();
        
        return redirect('admin/profile/edit?id=' . $request->id);
    }
    
     // 
   
}
