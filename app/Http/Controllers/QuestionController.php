<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Model\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{

  public function __construct()
  {
    $this->middleware('jwt', ['except' => ['index', 'show']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return QuestionResource::collection(Question::latest()->get());
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(QuestionRequest $request)
  {
    $validatedData = $request->all();
    $question = Question::create($validatedData);
    return response($question);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Model\Question  $question
   * @return \Illuminate\Http\Response
   */
  public function show(Question $question)
  {
    $questions = new QuestionResource($question);
    return $questions;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Model\Question  $question
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Question $question)
  {
    $validatedData = $request->all();
    $question->update($validatedData);
    return response()->json([
      'success' => true,
      'message' => 'Questions updated'
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Model\Question  $question
   * @return \Illuminate\Http\Response
   */
  public function destroy(Question $question)
  {
    $question->delete();
    return response()->json([
      'success' => true,
      'message' => "$question->title deleted successfully"
    ]);
  }
}
