<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function show(Question $question)
    {
        // $question = Question::where('slug', $slug)->first();
        // $question->increment('views');
        // $question->user;
        $comments = $question->comments;
        return response()->json($comments, 200);
    }

    public function store(Request $request)
    {
    	$request->validate([
            'body'=>'required',
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        $comment = Auth::user()->comments()->create($input);

        return response()->json([
            'message' => 'Your comment has been Stored.',
            'result' => $comment
        ], 200);
    }

    public function destroy(Comment $comment)
    {

        if ( $comment->delete()) {
            return response()->json([
                'message' => 'Your comment has been deleted',
            ], 200);
        } else {
            return response()->json([
                'message' => $resp->message(),
            ], 401);
        }

        // $resp = Gate::inspect('delete', $question);

        // if ($resp->allowed() && $question->delete()) {
        //     return response()->json([
        //         'message' => 'Your question has been deleted',
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'message' => $resp->message(),
        //     ], 401);
        // }
    }
}
