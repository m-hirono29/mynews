<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 追記
use App\Models\News;

class NewsController extends Controller
{
    //
    public function index(Request $request)
    {
        $posts = News::all()->sortByDesc('update_at');
        
        if (count($posts) > 0) {
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

    
    // news/index.blade.php ファイルに渡している
    //　また　view テンプレートに　headline、posts、という変数を渡している
    
    return view('news.index', ['headline' => $headline, 'posts' => $posts]);
    }
}
