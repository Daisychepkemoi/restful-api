<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Questions;
use App\Comments;
use App\Answers;
use Validator;

class QuestionsController extends Controller
{
    public function index()
    {
        $Questions = Questions::with(['Answers', 'Comments'])->get();

        return $this->sendResponse($Questions->toArray(), 'Questions retrieved successfully.');
    }
    public function createQuestion(Request $request){
        $question = new Questions;
        $question->users_id = $request->users_id;
        $question->body = $request->body;
        $question->save();

        return response()->json([
        "message" => "question record created"
    ], 201);
    }
   
   public function updateQuestion(Request $request,$id) {

        $input = $request->all();
        $validator = Validator::make($input, [
            'body' => 'required'
        ]);
         if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

         if (Questions::where('id', $id)->exists()) {
        $Question = Questions::where('id', $id)->find($id);
        $Question->body = $input['body'];
        $Question->save();
        return response()->json([$Question,
                "message" => "Question updated successfully"
            ], 200);
    }
    else{
        return response()->json([
                "message" => "Question not found"
            ], 404);
    }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Question = Questions::find($id);


        if (is_null($Question)) {
            return $this->sendError('Question not found.');
        }
         $questionone = Questions::where('id',$id)->with(['Answers', 'Comments'])->get();

        return $this->sendResponse($questionone->toArray(), 'Questions retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Questions $Questions)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'body' => 'required'
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Questions = new Questions();
        $Question->body = $input['body'];
        $Questions->save();


        return $this->sendResponse($Question->toArray(), 'Question updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Questions::find($id);
        if (is_null($question)) {
            return $this->sendError('Question not found.');
        }
        $Comments =  Comments::where('questions_id', $id)->delete();
        $Answers =  Answers::where('questions_id', $id)->delete();
        $Question = Questions::where('id', $id)->delete();
        //*check on it later*

        return $this->sendResponse('', 'Questions deleted successfully.');
    }
}
