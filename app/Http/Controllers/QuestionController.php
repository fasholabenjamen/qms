<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Question;
use App\Choice;
use Importer;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $questions=Question::paginate(40);
        $categories=Question::select('categories')->distinct()->get('categories');
        return view('question_list')->with([
            'questions'=>$questions,
            'categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('upload');
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
          // Validating the Excel File
       $validator=Validator::make($request->all(),[
        'file'=>'required|mimes:csv,xls,xlsx|max:4096',
    ]);
    // if file is true excel file
    if($validator->passes()){
        
        $file=$request->file('file'); // get the file to $file variable
        $dateTime=date('Ymd_His');
        $fileName=$dateTime.'-'.$file->getClientOriginalName(); // get the original file name 
        $save_path=public_path('upload_questions'); //public path to save file
        $file->move($save_path,$fileName); // moving the file to upload_questions folder
        $file_path=$save_path.'/'.$fileName; // file path
        $excel=Importer::make('Excel'); // initialiazing Importer
        $excel->load($file_path); // load file
        $collection = $excel->getCollection(); 
        File::delete($file_path); // Delete the file on server
        if(sizeof($collection[0])==18){ // check if excel file has 18 column
            $error_log=[];
            $validity_status=true;
            $length=sizeof($collection);
            for($row=1;$row<$length;$row++){
                $valid=null;
                try{
                    $question=$this->rename_key($collection[$row]);
                    $valid=$this->validator($question);
                   
                    if(is_array($valid)){
                        $validity_status=false;
                        $line=$row+1;
                        $error="Errors on Line ".$line." of your excel file";
                        array_unshift($valid,$error);
                        $new_log=array_merge($error_log,$valid);
                        $error_log=$new_log;
                    }  
                }
                catch(\Exception $e){
                    return back()->with('errors',$e->getMessage());
                }
            }
            if($validity_status){
                // Save to DB
                for($row=1;$row<$length;$row++){
                    $question=$this->rename_key($collection[$row]);
                    $this->save_question($question);
                }
                $msg='Data Saved Successfully, '.($length-1).' row added.';
                return back()->with('success',$msg);
            }
            else{
                return back()->with('errors',$error_log);
            }
        }
        else{
            File::delete($file_path);
            return back()->with('errors',[
                0=>'Incomplete number of column , Column suppose to be 18',
            ]);
            
        }
        return back()->with('success','Excel file uploaded Successfully');
    }
    else{
        return back()->with('errors',$validator->errors()->all());
    }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
        $choices=$question->choice;
        return view('question_view')->with([
            'question'=>$question, 
            'choices'=>$choices,]);
        
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
        return view('edit_question')->with('question',$question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question'=>'required|string',
            'is_general'=>'required',
            'category'=>'required',
            'point'=>'required|integer',
            'duration'=>'required|integer',
        ]);
        $question->where('id',$question->id)->update([
            'question'=>$request->input('question'),
            'is_general'=>$request->input('is_general'),
            'categories'=>$request->input('category'),
            'point'=>$request->input('point'),
            'icon_url'=>$request->input('icon_url'),
            'duration'=>$request->input('duration'),
        ]);
        
        return redirect()->route('question.show',$question->id)->withSuccess('Question Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        $question->delete();
        $question->choice()->delete();
        return redirect()->route('question.index')->withSuccess('Question Deleted');
    
    }

    public function sort($category=null){
        $questions=Question::where('categories',$category)->paginate(40);
        $categories=Question::select('categories')->distinct()->get('categories');
        return view('question_list')->with([
            'questions'=>$questions,
            'categories'=>$categories]);
    }
    private function rename_key($question){
        $rename=[
            0=>'question',
            1=>'is_general',
            2=>'categories',
            3=>'point',
            4=>'icon_url',
            5=>'duration',
            6=>'choice_1',
            7=>'is_correct_choice_1',
            8=>'icon_url_1',
            9=>'choice_2',
            10=>'is_correct_choice_2',
            11=>'icon_url_2',
            12=>'choice_3',
            13=>'is_correct_choice_3',
            14=>'icon_url_3',
            15=>'choice_4',
            16=>'is_correct_choice_4',
            17=>'icon_url_4',  
        ];
        $question=array_combine(array_map(function($el) use ($rename){
            return $rename[$el];
        }, array_keys($question)), array_values($question));
        return $question;
    }
    private function validator($question){
        $validator=Validator::make($question,[
            'question'=>'required|string',
            'is_general'=>'required|boolean',
            'categories'=>'required|string',
            'point'=>'required|integer',
            'icon_url'=>'string',
            'duration'=>'required|integer',
            'is_correct_choice_1'=>'boolean',
            'icon_url_1'=>'string',
            'is_correct_choice_2'=>'boolean',
            'icon_url_2'=>'string',
            'is_correct_choice_3'=>'boolean',
            'icon_url_3'=>'string',
            'is_correct_choice_4'=>'boolean',
            'icon_url_4'=>'string',
        ]);
        return $validator->passes() ? true : $validator->errors()->all();
    }
    private function save_question($question_data){
        $question =new Question;
        $question->question=$question_data['question'];
        $question->is_general=$question_data['is_general'] ==true ? 1:0;
        $question->categories=$question_data['categories'];
        $question->point=$question_data['point'];
        $question->icon_url=$question_data['icon_url'];
        $question->duration=$question_data['duration'];
        $question->save();

        if($question_data['choice_1']!=null){
            Choice::create([
                'question_id'=>$question->id,
                'description'=>$question_data['choice_1'],
                'is_correct_choice'=>$question_data['is_correct_choice_1']==true ? 1:0,
                'icon_url'=>$question_data['icon_url_1'],
            ]);
        }
        if($question_data['choice_2']!=null){
            Choice::create([
                'question_id'=>$question->id,
                'description'=>$question_data['choice_2'],
                'is_correct_choice'=>$question_data['is_correct_choice_2']==true ? 1:0,
                'icon_url'=>$question_data['icon_url_2'],
            ]);
        }
        if($question_data['choice_3']!=null){
            Choice::create([
                'question_id'=>$question->id,
                'description'=>$question_data['choice_3'],
                'is_correct_choice'=>$question_data['is_correct_choice_3']==true ? 1:0,
                'icon_url'=>$question_data['icon_url_3'],
            ]);
        }
        if($question_data['choice_4']!=null){
            Choice::create([
                'question_id'=>$question->id,
                'description'=>$question_data['choice_4'],
                'is_correct_choice'=>$question_data['is_correct_choice_4']==true ? 1:0,
                'icon_url'=>$question_data['icon_url_4'],
            ]);
        }
        return true;
    }
}
