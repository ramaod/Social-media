<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReactionController extends Controller
{

    public function store(Request $request,$id)
    {
        $data = Validator::make(
            $request->all(),
            [
                'value' => 'required|in:like,dislike',
            ]
        );
        if($data->fails())
           return Response()->json(['errors'=>$data->errors()]);

        $post = Post::find($id);
        if(!$post)
            return Response()->json(['errors'=>[
                'post' => ['post is not exist.']
            ]]);

        try {
            $reaction = Reaction::where('user_id', Auth::user()->id)->where('post_id', $id)->firstOrFail();
        }
        catch (Exception $e){
            $likes=Reaction::query()
            ->where('post_id',$post->id)
            ->where('check_likes',true)
            ->count();
        $reaction = Reaction::create(
            [
                'post_id' => $id,
                'user_id' => Auth::user()->id,
                'value' => $request['value'],
                'likes' => $likes
            ]
        );

        /*if($reaction['value'] == 'like')
        $post->like++;
        else
        $post->dislike++;

        $post->save();
        $reaction->save();

        return Response()->json(['reaction' => $reaction]);
        }

        if($reaction['value'] == 'like')
            $post->like--;
        else
            $post->dislike--;
        $post->save();

        if($request['value'] == 'like')
            $post->like++;
        else
            $post->dislike++;



        if($reaction->value == $request['value']) {
            $reaction->delete();
            return Response()->json(['message' => 'cancel reaction.']);
        }

        $reaction->value = $request['value'];
        $reaction->save();
        $post->save();

        return Response()->json(['reaction' => $reaction]);


    }


}*/

        }
        return Response()->json(['reaction' => $reaction]);
    }
}

    

