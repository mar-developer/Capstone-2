<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Input;
use Session;
use Redirect;


class UserAccount extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = \App\User::find($id);

        return view('/user_account', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = \App\User::find($id); {
            $request->validate(
                [
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'contact_number' => ['required', 'string', 'min:11'],
                ]
            );
        }

        if ($user->email != $request->email) {
            $request->validate(
                [
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                ]
            );

            $user->email = $request->email;
        }

        if (Input::has('old_password')) {

            $request->validate(
                [
                    'old_password' => ['required', 'string', 'min:8'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]
            );

            if (!Hash::check($request->old_password, $user->password)) {
                Session::flash('message', "Old Password is incorrect");
                return Redirect::back();
            } else {
                $user->password = Hash::make($request->password);
            }
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->contact_number = $request->contact_number;

        if (Input::hasFile('image')) {
            $file = $request->file('image');
            $user->img_path = $file->getClientOriginalName();
            $file->move('images/profile', $file->getClientOriginalName());
        }


        $user->save();

        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
