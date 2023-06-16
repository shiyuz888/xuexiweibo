<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Microblog;
use Illuminate\Support\Facades\Auth;

class MicroblogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        Auth::user()->microblogs()->create([
            'content' => $request['content']
        ]);
        session()->flash('success', '发布成功！');
        return redirect()->back();
    }


    public function destroy(Microblog $microblog)
    {
        $this->authorize('destroy', $microblog);
        $microblog->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}
