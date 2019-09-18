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
        // $user = auth()->user();

        $Questions = Questions::with(['Answers', 'Comments'])->get();

        return $this->sendResponse($Questions->toArray(), 'Questions retrieved successfully.');
    }
    public function createQuestion(Request $request){
     $input = $request->all();
        $validator = Validator::make($input, [
            'body' => 'required',
            // 'users_id' => 'required'
        ]);
        if ($validator->fails())
          {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $question = new Questions;
        $question->users_id = auth()->user()->id;
        $question->body = $request->body;
        $question->save();

        return response()->json(["message" => "question record created"], 201);
    }
   
   public function updateQuestion(Request $request,$id) {
           

        $input = $request->all();
        $validator = Validator::make($input, [
            'body' => 'required'
        ]);
         if ($validator->fails())
          {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $userid = Questions::where('id',$id)->first();
        // dd(Questions::where('id',$id)->first()->users_id);
         if (Questions::where('id', $id)->exists())
            {
                if(auth()->user()->id == $userid->users_id)
                {
                $Question = Questions::where('id', $id)->find($id);
                $Question->body = $input['body'];
                $Question->save();
                return response()->json([$Question, "message" => "Question updated successfully"], 200); 
                 }
        
            else{
                 return response()->json(["message" => " Unauthorized "], 401);
                }
        }
          else{
            return response()->json(["message" => "Question not found"], 404);
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
            return response()->json(["message" => "Question not found"], 404);
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
 


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=auth()->user();
        $question = Questions::find($id);

        if (is_null($question)) {
            return $this->sendError('Question not found.');
        }
        else{

             if(auth()->user()->id == Questions::where('id',$id)->first()->users_id)
                {
                    $Comments =  Comments::where('questions_id', $id)->delete();
                    $Answers =  Answers::where('questions_id', $id)->delete();
                    $Question = Questions::where('id', $id)->delete();
                    return $this->sendResponse('', 'Questions deleted successfully.');
     
                }
            else
            {
                return response()->json(["message" => "Unauthorized"], 401);

            }
        }
       
        //*check on it later*

    }
}
