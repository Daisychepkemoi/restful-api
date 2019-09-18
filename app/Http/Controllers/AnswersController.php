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
        $Answers = Answers::where('questions_id', $id)->with(['Comments'])->get();

        return $this->sendResponse($Answers->toArray(), 'Answers retrieved successfully.');
    }
   
    public function show($id, $answerid)
    {
        $question = Questions::find($id);
        $Answer = Answers::find($answerid);

        if (is_null($question)) {
            return $this->sendError('Answer not found.');
        }
        if (is_null($Answer)) {
            return $this->sendError('Answer not found.');
        }
        $oneanswer = Answers::where('id', $answerid)->with(['Comments'])->get();

        return $this->sendResponse($oneanswer->toArray(), 'Answer retrieved successfully.');
    }
    public function createAnswer(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'body' => 'required',
            // 'questions_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $answer = new Answers;
        $answer->users_id = auth()->user()->id;
        $answer->questions_id = $id;
        $answer->body = $request->body;
        $answer->save();

        return response()->json([
        "message" => "Answer created successfully."], 201);
    }
    public function updateAnswer(Request $request, $id, $answerid)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'body' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (Answers::where('id', $answerid)->where('questions_id', $id)->exists()) {
            if (auth()->user()->id == Answers::where('id', $answerid)->where('questions_id', $id)->first()->users_id) {
                $Answer = Answers::where('id', $id)->find($id);
                $Answer->body = $input['body'];
                $Answer->save();
                return response()->json([$Answer, "message" => "Answer updated successfully"], 200);
            } else {
                return response()->json(["message" => "Unauthorized !"], 401);
            }
        } else {
            return response()->json(["message" => "Answer not found"], 404);
        }
    }
    public function destroy($id, $answerid)
    {
        $question = Questions::find($id);
        $Answer = Answers::where('id', $answerid)->where('questions_id', $id)->find($answerid);

        if (is_null($question)) {
            return $this->sendError('Answer not found.');
        }
        if (is_null($Answer)) {
            return $this->sendError('Answer not found.');
        } else {
            if (auth()->user()->id == Answers::where('id', $answerid)->where('questions_id', $id)->first()->users_id) {
                $Comments =  Comments::where('answers_id', $id)->delete();
                $Answers =  Answers::where('id', $answerid)->delete();
                $allanswers =  Answers::where('id', $answerid)->get();
                return $this->sendResponse($allanswers->toArray(), 'Answer deleted successfully.');
            } else {
                return response()->json(["message" => "Unauthorized !"], 401);
            }
        }
    }
}
