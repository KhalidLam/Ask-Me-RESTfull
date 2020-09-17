<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public $successStatus = 200;

    /**
     *  login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user  = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;
            $user['access_token'] = $token;
            return response()->json(['result' => $user], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function authLogin()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user  = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;
            return response()->json(['result' => ['token' => $token, 'user' => $user]], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }


    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        // $input['email_verified_at'] = now();
        $user = User::create($input);

        $token = $user->createToken('AuthToken')->accessToken;
        $user['access_token'] = $token;
        // $success['user'] =  $user;

        return response()->json(['result' => $user], $this->successStatus);
    }

    public function authRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            // 'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        // $input['email_verified_at'] = now();
        $user = User::create($input);

        $token = $user->createToken('AuthToken')->accessToken;
        // $user['access_token'] = $token;
        // $success['user'] =  $user;

        return response()->json(['result' => ['token' => $token, 'user' => $user]], $this->successStatus);
    }


    public function logout()
    {
        // Auth::user()->token()->revoke();
        Auth::user()->token()->delete();

        return response()->json(['result' => ['message' => "The Token has been deleted"]], $this->successStatus);
    }


    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['result' => $user], $this->successStatus);
    }

    public function authData()
    {
        return response()->json(request()->user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::has('questions')->get();
        foreach ($users as $user) {
            $user["posts_count"] = $user->questions()->count();
        }
        // $users = User::where('votes', '>', 100)->paginate(15);
        return response()->json(['result' => $users]);
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user["answer_count"] = $user->answers()->count();
        $user["post_count"] = $user->questions()->count();
        $user["tag_count"] = 2;
        $user["comment_count"] = 0;


        return response()->json($user);

        // {
        //     "id": 3,
        //     "name": "Garret Hermann",
        //     "email": "abelardo01@example.net",
        //     "email_verified_at": "2020-08-11 14:28:21",
        //     "created_at": "2020-08-11 14:28:22",
        //     "updated_at": "2020-08-11 14:28:22"
        // }

        // user = {
        //   id: 1,
        //   answer_count: 0,
        //   comment_count: 0,
        //   created_at: "2020-08-26T12:34:12.000Z",
        //   post_count: 2,
        //   tag_count: 2,
        //   username: "testuser",
        // };
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
