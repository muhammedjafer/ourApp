<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function showAvatarForm()
    {
        return view('avatar-form');
    }

    public function storeAvatar(Request $request)
    {
        //->store('public/avatars'.$request->id);
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);
        $input = $request->file('avatar');
        $user = auth()->user();
        $fileName = $user->id . '-' . uniqid() . '.jpg';
        $imgData = Image::make($input)->fit(120)->encode('jpg');
        //$imgData->storeAs('public/avatars/', $fileName);\
        Storage::put('public/avatars/' . $fileName,  $imgData);

        $oldAvatar = $user->avatar;

        $user = User::find($user->id);
        if ($oldAvatar != '/fallback-avatar.jpg')
        {
            Storage::delete(str_replace("/storage/", 'public/', $oldAvatar));
            $user->avatar = $fileName;
        } else {
            $user->avatar = $fileName;
        }

        $user->save();

        return back()->with('success','Image changed successfully');
        //return view('profile-posts');
    }

    public function profile(User $user)
    {
        $this->getSharedData($user);
        return view('profile-posts', [
        'posts' => $user->posts()->latest()->get()]);
    }

    public function profileFollowers(User $user)
    {
        $this->getSharedData($user);
        return view('profile-followers', [
            'posts' => $user->posts()->latest()->get()]);
    }

    public function profileFollowing(User $user)
    {
        $this->getSharedData($user);
        return view('profile-following', [
            'posts' => $user->posts()->latest()->get()]);
    }

    public function logout() {
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out.');
    }

    public function showCorrectHomepage() {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt([
            'username' => $incomingFields['loginusername'], 
            'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You have successfully logged in.');
        } else {
            return redirect('/')->with('failure', 'Invalid login.');
        }
    }

    public function register(Request $request) {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/')->with('success', 'Thank you for creating an account.');
    }

    private function getSharedData($user) 
    {
        $currentlyFollowing = 0;

        if (auth()->check())
        {
            $currentlyFollowing = Follow::where([
            'user_id' => auth()->user()->id,
            'followeduser' => $user->id])->count();
        }

        View::share('sharedData', [
            'username' => $user->username, 
            'postCount' => $user->posts()->count(),
            'currentlyFollowing' => $currentlyFollowing]);
    }
}
