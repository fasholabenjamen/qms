@extends('layouts.base')
@section('content')
    
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add Choice</h1><br />
            @if(session('errors'))
                  @foreach ($errors as $error)
                      <li>{{ $error }}</li>
                  @endforeach
                @endif
                @if(session('success'))
                 <li>{{ session('success') }}</li>
            @endif
           
          </div>
           <h3 class="h2">Question: {{ $question->question }}</h3>
          <div class="table-responsive">
          <form method="POST" action="{{ route('choice.store') }}">
          @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}" />
            <div class="form-group">
              <label for="exampleInputEmail1">Description</label>
              <textarea class="form-control" name="description" reqiured placeholder="Enter Description here">{{ old('description') }}</textarea>
              @error('description')
                                    
                                        <strong>{{ $message }}</strong>
                                
                                @enderror
               </div>
              <div class="form-group">
                <label for="exampleSelect">Is Correct Choice</label>
                <select name="is_correct_choice" class="form-control" id="exampleSelect" required>
                 <option value="" >Correct Choice ?</option>
                  <option value="1" >Yes</option>
                  <option value="0" >No</option>
                </select>
              </div>
              
              <div class="form-group">
                <label for="exampleInput">Icon-Url</label>
                <input type="text" name="icon_url" value="{{ old('icon_url') }}" class="form-control" id="exampleInput">
                @error('icon_url')
                                    
                                        <strong>{{ $message }}</strong>
                                
                                @enderror
              </div>
             
            <button type="submit" class="btn btn-primary">Save</button> <a href="{{ route('question.show',$question->id) }}"><button type="button" class="btn btn-danger ">Back</button></a>
          </form>
           
          </div>
        </main>
      </div>
    </div>

@endsection