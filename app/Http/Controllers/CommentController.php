<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    //Post - Enter A New Comment On Post
    public function store(Request $request, $post_id): JsonResponse
    {
         //Get User ID
         $user_id = auth()->user()->id;

         //Check Comment Content Assign
         if (!isset($request->comment)) {
             return response()->json([
                 'status' => false,
                 'error_code' => 14,
                 'message' => 'Comment content does not assigned'
             ]);
         }
 
         //Create A New Comment On Post
         $newComment = new Comment();
 
         $newComment->user_id = $user_id;
         $newComment->post_id = $post_id;
         $newComment->content = $request->comment;
 
  
         $newComment->save();
 
         return response()->json([
             'status' => true,
             'message' => 'Comment successfully added'
         ]);
    }

    //Post - Delete A Comment On Post
    public function delete(Request $request, $comment_id): JsonResponse
    {
        //Get User ID
        $user_id = auth()->user()->id;

        //Get the comment
        $comment = Comment::find($comment_id);

        //Check Cardinality
        if ($comment->user_id != $user_id) {
            return response()->json([
                'status' => false,
                'error_code' => 12,
                'message' => 'Owner of comment only one whom allowed to delete the comment'
            ]);
        }

        //Delete the comment
        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'comment successfully deleted'
        ]);
    }

    //Post - Update Comment Details
    public function update(Request $request, $comment_id): JsonResponse
    {
        $data = Validator::make(
            $request->all(),
            [
                'comment' => 'required|string|max:255',
            ]
        );

        if($data->fails()){
            return Response()->json(['errors'=>$data->errors()]);}
        
        $comment=Comment::find($comment_id);
        if(!$comment)
                return Response()->json(['error'=>'this comment not found.']);
        $comment->update($request->all());
            if ($comment)
            return Response()->json(['message'=>'comment updated sucssufly']);
    }

    //Get - Get Post Comments
    public function getComments($post_id): JsonResponse
    {
        //Get Postt Comments With Details
        $comments =
            DB::table('comments AS c')
                ->select('c.id as comment_id', 'c.user_id as user_id', 'u.name','c.content as comment_content', 'c.created_at', 'c.updated_at')
                ->join('users AS u', 'c.user_id', '=', 'u.id')
                ->where('c.post_id', '=', $post_id)
                ->get();

        //Validate Records Existing
        if ($comments->count() < 1) {
            return response()->json([
                'status' => false,
                'error_code' => 11,
                'message' => 'No Comments Have Found',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Comments Successfully Retrieved',
            'data' => $comments
        ]);
    }

}
