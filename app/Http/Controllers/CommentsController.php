<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
use App\Questions;
use App\Answers;
use Validator;
class CommentsController extends Controller
{
	 public function index($id,$answerid)
	{
    $Comments = Comments::where('answers_id',$answerid)->get();//find out how to ensure question id and answerid are same as those of the answers

    return $this->sendResponse($Comments->toArray(), 'Comments retrieved successfully.');
	}
    public function createComment(Request $request){
        $comment = new Comments;
        $comment->users_id = $request->users_id;
        $comment->questions_id = $request->questions_id;
        $comment->answers_id = $request->answers_id;
        $comment->body = $request->body;
        $comment->save();

        return response()->json([
        "message" => "Comment created successfully."], 201);
    }

    public function show($id,$answerid,$commentid)
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
         $onecomment = Comments::where('id',$commentid)->where('answers_id',$answerid)->get();

        return $this->sendResponse($onecomment->toArray(), 'Comment retrieved successfully.');
    }
    public function updateComment(Request $request, $commentid,$id,$answerid) {

        $input = $request->all();
        $validator = Validator::make($input, [
            'body' => 'required'
        ]);
         if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
         if (Comments::where('id', $commentid)->where('questions_id',$id)->where('answers_id',$answerid)->exists()) {
        $Comment = Comments::where('id', $commentid)->find($commentid);
        $Comment->body = $input['body'];
        $Comment->save();
        return response()->json([$Comment,
                "message" => "Comment updated successfully"
            ], 200);
    }
    return response()->json([
                "message" => "Comment not found"
            ], 404);
    }

        // if (Comments::where('id', $commentid)->exists()) {
        //     $comment = Comments::find($id);
        //     $comment->body = is_null($request->body) ? $comment->body : $request->body;
        //     $comment->save();

        //     return response()->json([$comment,
        //         "message" => "records updated successfully"
        //     ], 200);
        //     } else {
        //     return response()->json([
        //         "message" => "Student not found"
        //     ], 404);
            
        // }
    
    public function destroy($id,$answerid,$commentid)
    {
    	$question = Questions::find($id);
    	$Answer = Answers::find($answerid);
    	$Comment = Comments::find($commentid);

    	if (is_null($question)) {
            return $this->sendError('Comment not found.');
        }
        if (is_null($Comment)) {
            return $this->sendError('Comment not found.');
        }
        if (is_null($Answer)) {
            return $this->sendError('Comment not found.');
        }
        $Comments =  Comments::where('id', $commentid)->delete();
        $allcomments =  Comments::where('id', $commentid)->get();


        return $this->sendResponse($allcomments->toArray(), 'Comment deleted successfully.');
    }
    //
}
