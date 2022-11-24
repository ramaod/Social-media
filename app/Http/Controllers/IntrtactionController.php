<?php

namespace App\Http\Controllers;

use App\Models\Intrtaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Post;
use Illuminate\Http\Response;
class IntrtactionController extends Controller
{

    public function like($id)
    {
        $user_id=Auth::id();
        $post=Post::query()->find($id);
        $intrtaction=Intrtaction::query()
        ->where('user_id',$user_id)
        ->where('post_id',$id)->first();
        if($intrtaction){
            $intrtaction->check_likes=!$intrtaction->check_likes;
            $intrtaction->save();
            return response()->json(status:Response::HTTP_OK);
            } else 
            {
                $intrtaction= Intrtaction::create([
                    'post_id' => $post->id,
                    'user_id' =>    $user_id,
                    'check_likes'=> true
                ]);
                return response()->json(status:Response::HTTP_OK); 
        }

        }
}
