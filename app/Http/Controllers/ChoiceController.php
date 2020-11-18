<?php

namespace App\Http\Controllers;

use App\Choice;
use App\Question;

use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_choice($id=null)
    {
        //
        $question=Question::findOrfail($id);
        return view('add_choice')->with('question',$question);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'description'=>'required',
            'is_correct_choice'=>'boolean',
            'question_id'=>'integer|required',
        ]);
        $choice=new Choice;
        $choice->question_id=$request->input('question_id');
        $choice->description=$request->input('description');
        $choice->is_correct_choice=$request->input('is_correct_choice');
        $choice->icon_url=$request->input('icon_url');
        $choice->save();

        // make this the only correct choice
        if($choice->is_correct_choice==true){
            // set all choice is_correct_choice column to 0
            $choice->where('question_id',$choice->question_id)->update([
                'is_correct_choice'=>0,
            ]);
            $choice->where('id',$choice->id)->update([
                'is_correct_choice'=>1,
            ]);
        }
        return redirect()->route('question.show',$choice->question_id)->with('success','Choice Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function show(Choice $choice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function edit(Choice $choice)
    {
        //
        $question=$choice->question;
        return view('edit_choice')->with(['choice'=>$choice, 'question'=>$question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Choice $choice)
    {
        //
        $request->validate([
            'description'=>'required',
            'is_correct_choice'=>'boolean',
        ]);
       $choice->update([
        'description'=>$request->input('description'),
        'is_correct_choice'=>$request->input('is_correct_choice'),
       ]);

        // make this the only correct choice
        if($choice->is_correct_choice==true){
            // set all choice is_correct_choice column to 0
            $choice->where('question_id',$choice->question_id)->update([
                'is_correct_choice'=>0,
            ]);
            $choice->where('id',$choice->id)->update([
                'is_correct_choice'=>1,
            ]);
        }
        return redirect()->route('question.show',$choice->question_id)->withSuccess('Choice Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Choice  $choice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Choice $choice)
    {
        //
        $choice->delete();
        return back()->withSuccess('Choice Deleted');
    }
}
