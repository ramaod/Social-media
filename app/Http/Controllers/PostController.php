<?php
namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Intrtaction;
use Illuminate\Http\Request;
use My\Namespace\Success;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class PostController extends Controller
{
    public function likes($id)
    {
        $likes=Intrtaction::query()
        ->where('post_id',$id)
        ->where('check_likes',true)
        ->count();
        
        return Response()->json(['likes'=> $likes]);

        
    }
    public function index()
    {
        $posts = Post::all();
        $result = array();
        foreach ($posts as $post){
            $user = User::where('id',$post->user_id)->firstOrFail();
            array_push($result,[
                'post' => $post,
                'user' => $user,
                ]);
        }
        return Response()->json([
            'posts' => $result
            ]);
    }

    public function profile()
    {
        $posts = Post::where('user_id',Auth::user()->id)->get();
        return Response()->json([
            'posts' => $posts,
            'user' => Auth::user()
        ]);
    }

    public function store(Request $request)
    {
        $data = Validator::make(
            $request->all(),
            [
                'text' => 'string|max:255',
                'image'=> 'image|mimes:jpeg,jpg,png',
                'type'=>  'required|string|in:Math,Sciences,Gegraphy,History,Arabic,English,French,Physics,Chemistry,Arts'
            ]
        );

        if($data->fails())
            return Response()->json(['errors'=>$data->errors()]);


        $post = Post::create([
            'user_id' => Auth::user()->id,
            'text' => $request['text'],
            'image' => $request['image'],
            'type' => $request['type'],
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
            $path = $request->file('image')->storeAs('public/users/images'.$post->id, $filenameToStore);
            
           // $post->image = URL::asset('storage/users/images/'.$post->id, $filenameToStore);
            $post->save();
            // <img src="/storage/users/images/{{$user->id}}">
        }
        return Response()->json(['post'=> $post]);
    }

    
    public function update(Request $request, $post_id)
    {
        $data = Validator::make(
            $request->all(),
            [
                'text' => 'string|max:255',
                'image'=> 'image|mimes:jpeg,jpg,png',
            ]
        );

        if($data->fails()){
            return Response()->json(['errors'=>$data->errors()]);}
        
        $post=Post::find($post_id);
        if(!$post)
                return Response()->json(['error'=>'this post not found.']);
        $post->update($request->all());
            if ($post)
            return Response()->json(['message'=>'post updated sucssufly']);
 }
        
    
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post->user_id != Auth::user()->id)
            return Response()->json(['error'=>'this post is not belong to you.']);
        $post->delete();
        return Response()->json(['message'=>'post deleted successfully.']);
    }
}
