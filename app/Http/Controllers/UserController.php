<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;

class UserController extends controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return Response()->json(['users' => User::all()]);
    }

    public function register(Request $request){
        $data = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email'=> 'required|email|max:255',
                'password'=> 'required|string|max:50',
                'phone' => 'required|string|max:20',
                'image' => 'nullable|image|mimes:jpeg,jpg,png',
                'type' => 'required|in:teacher,studant'
            ]
        );

        if($data->fails())
            return Response()->json(['errors'=>$data->errors()]);

        try{
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'phone' => $request['phone'],
                'type' => $request['type'],
                'image' => $request['image']
            ]);

            if ($request->hasFile('image')) {
                // Get filename with extension
                $filenameWithExt = $request->file('image')->getClientOriginalName();

                // Get just the filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                // Get extension
                $extension = $request->file('image')->getClientOriginalExtension();

                // Create new filename
                $filenameToStore = $filename.'_'.time().'.'.$extension;

                // Uplaod image
                $path = $request->file('image')->storeAs('public/users/images/'.$user->id, $filenameToStore);

                $user->image = URL::asset('storage/'.'users/images/'.$user->id.'/'.$filenameToStore);

                // <img src="/storage/users/images/{{$user->id}}">
            }

        }
        catch (Exception $exception){
            return Response()->json(['error'=>'email or phone number is invalid.']);
        }


        $token = $user->createToken('authToken')->plainTextToken;
        $user->save();
        return Response()->json([
            'user'=>$user,
            'token' => $token,
        ]);
    }


   public function login(Request $request){
   
   
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => 'Invalid login details'
            ], 401);
        }
    

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
    public function logout(){
        try{
            Auth::user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return Response()->json(['message'=>'log out successfully.']);
        }catch (Exception $exception){
            return Response()->json(['error'=>'log out failed.']);
        }
    }
  /*  public function toggleFriend($id)
    {
        $userFriends = auth()->user()->friends();

        if ($userFriends->find($id)) {
            $userFriends->detach([$id]);
            return $this->responseHelper->successResponse(true, 'Removed Friend', []);
        }

        $userFriends->attach($id);

        return $this->responseHelper->successResponse(true, 'Added Friend', []);
    }

    /**
     * @return JsonResponse
     */
   /* public function getFriends()
    {
        $userFriends = auth()->user()->friends()->get();
        return $this->responseHelper->successResponse(true, 'All Friends', $userFriends);
    }*/

    public function search(Request $request)
    {
        $input = $request->all();
        $search_by = $input['search_by'];
        $search_text = $input['search_text'];
        // $query = Product::where('name', 'bbb')->get();
        $query = User::where($search_by, 'like', '%' . $search_text . '%')->get();
        return response()->json(['query' => $query]);
    }
}


