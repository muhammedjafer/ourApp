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
        //user_id logged in user
        // followed user is the user which is being followed the the logged in user
        $followedExist = Follow::where(['user_id' => auth()->user()->id, 
        'followeduser' =>  $user->id])->count();

        if ($followedExist)
        {
            return back()->with('failure', 'you already follow this account');
        }

        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with('success', 'user successfully followed this account');;
    }

    public function removeFollow(User $user)
    {
        Follow::where(['user_id' => auth()->user()->id,
        'followeduser' => $user->id])->delete();

        return back()->with('success', 'user successfully unfollowed this account');
    }
}
