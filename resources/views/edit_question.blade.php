@extends('layouts.base')
@section('content')
    
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Question</h1>
            
          </div>
          <div class="table-responsive">
          <form method="POST" action="{{ route('question.update',$question->id) }}">
          @method("PUT")
          @csrf
          
            <div class="form-group">
              <label for="exampleInputEmail1">Question</label>
              <textarea class="form-control" name="question" reqiured placeholder="Enter Question here">{{ $question->question }}</textarea>
              @error('question')
                                    
                                        <strong>{{ $message }}</strong>
                                
                                @enderror
               </div>
              <div class="form-group">
                <label for="exampleSelect">Is_General</label>
                <select name="is_general" class="form-control" id="exampleSelect" required>
                  <option value="1" {{ $question->is_general==1 ? 'selected':'' }}>Yes</option>
                  <option value="0" {{ $question->is_general!=1 ? 'selected':'' }}>No</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInput">Category</label>
                <input type="text" name="category" value="{{ $question->categories }}" class="form-control" id="exampleInput" required placeholder="Enter Question category">
                @error('category')
                                    
                                        <strong>{{ $message }}</strong>
                                
                @enderror
              </div>
              <div class="form-group">
                <label for="exampleInput">Point</label>
                <input type="text" name="point" value="{{ $question->point }}" class="form-control" id="exampleInput" required placeholder="Enter Question point">
                @error('point')
                                    
                                        <strong>{{ $message }}</strong>
                                
                @enderror
              </div>
              <div class="form-group">
                <label for="exampleInput">Icon-Url</label>
                <input type="text" name="icon_url" value="{{ $question->icon_url }}" class="form-control" id="exampleInput">
                @error('icon_url')
                                    
                                        <strong>{{ $message }}</strong>
                                
                                @enderror
              </div>
              <div class="form-group">
                <label for="exampleInput">Duration</label>
                <input type="text" required name="duration" value="{{ $question->duration }}" class="form-control" id="exampleInput" placeholder="Enter Question duration">
              @error('duration')
                                    
                                        <strong>{{ $message }}</strong>
                                
                                @enderror
              </div>
            <button type="submit" class="btn btn-primary">Update Question</button>
          </form>
           
          </div>
        </main>
      </div>
    </div>

@endsection