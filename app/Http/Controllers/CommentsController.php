<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
use App\Questions;
use App\Answers;
use Validator;

class CommentsController extends Controller
{
    public function index($id, $answerid)
    {
        $Comments = Comments::where('answers_id', $answerid)->get();//find out how to ensure question id and answerid are same as those of the answers

        return $this->sendResponse($Comments->toArray(), 'Comments retrieved successfully.');
    }
    public function createComment(Request $request, $id, $answerid)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'body' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $comment = new Comments;
        $comment->users_id = auth()->user()->id;
        $comment->questions_id = $id;
        $comment->answers_id = $answerid;
        $comment->body = $request->body;
        $comment->save();

        return response()->json([
        "message" => "Comment created successfully."], 201);
    }

    public function show($id, $answerid, $commentid)
    {
        $question = Questions::find($id);
        $Answer = Answers::find($answerid);
        $Comment = Comments::find($commentid);

        if (is_null($question)) {
            return $this->sendError('Comment not found.');
        }
        if (is_null($Answer)) {
            return $this->sendError('Comment not found.');
        }
        if (is_null($Comment)) {
            return $this->sendError('Comment not found.');
        }
        $onecomment = Comments::where('id', $commentid)->where('answers_id', $answerid)->get();

        return $this->sendResponse($onecomment->toArray(), 'Comment retrieved successfully.');
    }
    public function updateComment(Request $request, $id, $answerid, $commentid)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'body' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // dd(Comments::where('id', $commentid)->where('questions_id',$id)->where('answers_id',$answerid)->first());
        if (Comments::where('id', $commentid)->where('questions_id', $id)->where('answers_id', $answerid)->exists()) {
            if (auth()->user()->id == Comments::where('id', $commentid)->where('questions_id', $id)->where('answers_id', $answerid)->first()->users_id) {
                $Comment = Comments::where('id', $commentid)->find($commentid);
                $Comment->body = $input['body'];
                $Comment->save();
                return response()->json([$Comment,
                            "message" => "Comment updated successfully"
                        ], 200);
            } else {
                return response()->json(["message" => "unauthorized"], 404);
            }
        }
        return response()->json(["message" => "Comment not found" ], 404);
    }

        
    
    public function destroy($id, $answerid, $commentid)
    {
        $question = Questions::find($id);
        $Answer = Answers::find($answerid);
        $Comment = Comments::where('id', $commentid)->where('answers_id', $answerid)->where('questions_id', $id)->find($commentid);
        // dd($Comment);
        if (is_null($question)) {
            return $this->sendError('Comment not found.');
        }
        if (is_null($Answer)) {
            return $this->sendError('Comment not found.');
        }
        if (is_null($Comment)) {
            return $this->sendError('Comment not found.');
        } else {
            if (auth()->user()->id == Comments::where('id', $commentid)->where('questions_id', $id)->where('answers_id', $answerid)->first()->users_id) {
                $Comments =  Comments::where('id', $commentid)->delete();
                $allcomments =  Comments::where('id', $commentid)->get();
                return $this->sendResponse($allcomments->toArray(), 'Comment deleted successfully.');
            } else {
                return response()->json(["message" => "unauthorized"], 404);
            }
        }
    }
    //
}
