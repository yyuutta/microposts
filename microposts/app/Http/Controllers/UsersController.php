<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Micropost;

use Symfony\Component\HttpFoundation\StreamedResponse;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'microposts' => $microposts,
        ];
        
        $data += $this->counts($user);

        return view('users.show', $data);
    }
    
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followings,
        ];

        $data += $this->counts($user);

        return view('users.followings', $data);
    }

    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followers,
        ];

        $data += $this->counts($user);

        return view('users.followers', $data);
    }
    
    public function favorites($id)
    {
        $data = [];
        $user = User::find($id);
        $favorites = $user->favorites()->paginate(10);
        
        $data = [
            'user' => $user,
            'microposts' => $favorites,
        ];
 
        $data += $this->counts($user);
        return view('users.favorites', $data);
    }
    
    public function store(Request $request)
    {
        //ここには名前とパスの編集コードを記述する事
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $user = \App\User::find($id);

        if (\Auth::id() === $user->id) {

            $user->microposts()->delete();
            $user->delete();
        }

        return redirect()->back();
    }
    
    public function download($id)
    {
        $user = \App\User::find($id);
        
        if (\Auth::id() === $user->id) {
            return  new StreamedResponse(
                function () {
                    
                    $users = User::all(['created_at', 'id', 'name', 'email'])->toArray();
                    $csvHeader = ['created_at', 'id', 'name', 'email'];
                    
                    array_unshift($users, $csvHeader);
        
                    $stream = fopen('php://output', 'w');
                    foreach ($users as $line) {
                        fputcsv($stream, $line);
                    }
                    fclose($stream);
                },
                200,
                [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="users.csv"',
                ]
            );
            return redirect()->back();
        }
    }
}
