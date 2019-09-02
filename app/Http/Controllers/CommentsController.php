<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
use App\Questions;
use App\Answers;

class CommentsController extends Controller
{
	 public function index($id,$answerid)
	{
    $Answers = Comments::where('questions_id',$id)->where('answers_id',$answerid)->get();

    return $this->sendResponse($Answers->toArray(), 'Comments retrieved successfully.');
	}
   
    public function show($id,$answerid)
    {
    	$question = Questions::find($id);
    	 $Answer = Answers::find($answerid);

    	if (is_null($question)) {
            return $this->sendError('Answer not found.');
        }
        if (is_null($Answer)) {
            return $this->sendError('Answer not found.');
        }
         $oneanswer = Answers::where('id',$id)->with(['Comments'])->get();

        return $this->sendResponse($oneanswer->toArray(), 'Answer retrieved successfully.');
    }
    public function destroy($id,$answerid)
    {
    	$question = Questions::find($id);
    	 $Answer = Answers::find($answerid);
    	if (is_null($question)) {
            return $this->sendError('Answer not found.');
        }
        if (is_null($Answer)) {
            return $this->sendError('Answer not found.');
        }
        $Comments =  Comments::where('answers_id', $id)->delete();
        $Answers =  Answers::where('id', $answerid)->delete();
        $answer =  Answers::where('id', $id)->get();

        return $this->sendResponse($answer->toArray(), 'Answer deleted successfully.');
    }
    //
}
