<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answers;
use App\Questions;
use App\Comments;
use Validator;
class AnswersController extends Controller
{
	 public function index($id)
	{
    $Answers = Answers::where('questions_id',$id)->with(['Comments'])->get();

    return $this->sendResponse($Answers->toArray(), 'Answers retrieved successfully.');
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
}
