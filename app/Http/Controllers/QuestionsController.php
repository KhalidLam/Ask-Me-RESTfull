<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class QuestionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(10);
        return response()->json($questions);
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
    public function store(AskQuestionRequest $request)
    {
        // Check if user exist
        // if (Auth::guard('api')->check()) {
        //     return response()->json([
        //         'message' => 'You can create Question ',
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'message' => 'Your can not create Question before login',
        //     ], 401);
        // }

        $question = Auth::user()->questions()->create($request->only('title', 'body'));
        return response()->json([
            'message' => 'Your question has been Stored.',
            'result' => $question
        ], 200);

        // return response()->json($question, 200);

        // Another way to do it
        // $question = new Question();
        // $question->title = $request->title;
        // $question->body = $request->body;
        // $question->user_id = Auth::user()->id;

        // if ($question->save()) {
        //     return response()->json($question, 200);
        // } else {
        //     return response()->json(['message' => 'Sorry, Question could not be added.'], 500);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');

        return response()->json($question, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $resp = Gate::inspect('update', $question);

        // For Api
        if ($resp->allowed() && $question->update($request->only('title', 'body'))) {
            return response()->json([
                'message' => 'Your question has been updated.',
                'result' => $question
            ]);
        } else {
            return response()->json([
                'message' => $resp->message(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $resp = Gate::inspect('delete', $question);

        // For Api
        if ($resp->allowed() && $question->delete()) {
            return response()->json([
                'message' => 'Your question has been deleted',
            ]);
        } else {
            return response()->json([
                'message' => $resp->message(),
            ]);
        }
    }
}
