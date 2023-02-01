<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user)
    {
        if ($user->id == auth()->user()->id)
        {
            return back()->with('failure', 'you can not follow yourself');
        }

        // you can not follow someone your are already following
        $followed = Follow::where(['user_id' => $user->id, 
        'followeduser' =>  auth()->user()->id])->get();

        if (isset($followed))
        {
            return back()->with('failure', 'you already follow this account');
        }

        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back();
    }

    public function removeFollow(User $user)
    {
        
    }
}
