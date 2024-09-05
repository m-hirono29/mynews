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
        //Validationを行う
        $this->validate($request, Profile::$rules);
        
        $profile = new Profile;
        $form = $request->all();
        
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        
        //データベースに保存する
        $profile->fill($form);
        $profile->save();
        
        // admin/profile/createにリダイレクトする
        return redirect('admin/profile/create');
    }
    
    // 以下を追記3
    public function index(Request $request)
    {
        $cond_tiitle = $request->cond_title;
        if ($cond_title != '') {
            //　検索されたら検索結果を取得する
            $posts = Profile::where('title', $cond_title)->get();
        } else {

            $posts = Profile::all();
        }
        return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_tiitle]);
    }
    
    // 以下を追記4
    public function edit(Request $request)
    {
        // Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    
    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Profile::$rules);
        // profile Modelからデータを取得
        $profile = Profile::find($request->id);
        // 送信されてきたフォームデータを格納する
        $profile_form = $request->all();
        
        unset($profile_form['remove']);
        unset($profile_form['_token']);
        
        // 該当するデータを上書きして保存する
        $profile->fill($profile_form)->save();
        
        return redirect('admin/profile');
    }
    
    // 以下を追記5
    
    public function delete(Request $request)
    {
        // 該当するprofile　Modelを取得
        $profile = profile::find($request->id);
        
        // 削除する
        $profile->delete();
        
        return redirect('admin/profile/');
    }
}
