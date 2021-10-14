<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\User;
use App\Notifications\UserAccount;

class UserController extends Controller
{
    /**
     * Get all users
     * @return json List of users
     */
    public function list()
    {
        return response()->json(
            User::select('id', 'name', 'email', 'role_id')->get()->makeHidden('userRole')
        );
    }

    /**
     * Change user password
     * @param Request $request
     * @return void
     */
    public function changePassword(Request $request)
    {

        if($request->input('new_pass') != $request->input('confirm_pass'))
        {
            return back()
                ->with('error', 'Password not match!')
                ->withInput();
        }
        
        $user = User::find($request->user()->id);

        if(!Hash::check($request->input('old_pass'), $user->password))
        {
            return back()
                ->with('error', 'Incorrect password!');
        }

        $user->password = Hash::make($request->input('new_pass'));
        $user->save();

        return back()
            ->with('success', 'Password was successfully updated!');
    }

    /**
     * Save new or edit user
     * @param $request Post method with id, category, amount and entry date
     * @return json list of user
     */
    public function save(Request $request)
    {
        $user = User::firstOrNew([
            'id' => $request->input('id')
        ]);

        $user->name = $request->input('name');
        if($user->id && $user->role_id != 1) $user->role_id = $request->input('role');
        
        if(!$user->id)
        {
            $user->email = $request->input('email');
            $user->role_id = $request->input('role');

            $user->password = Hash::make(Str::random(5));
            $user->save();

            $token = Password::broker()->createToken($user);
            // $password = DB::table('password_resets')->where('email', $user->email)->orderBy('created_at', 'desc')->first();
        
            $user->notify(new UserAccount('create', $user, url("reset-password/$token?email=$user->email")));
        }

        $user->save();

        return $this->list();
    }

    /**
     * delete user user
     * @param $request Post method with id
     * @return json list of user
     */
    public function delete(Request $request)
    {
        $user = User::find($request->input('id'));

        if($request->input('id'))
        {
            $user->delete();
        }
        else
        {
            return response()->json([
                'message' => $request->input('name').' is not found!'
            ]);
        }

        return $this->list();
    }

}
