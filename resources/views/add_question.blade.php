@extends('layouts.base')
@section('content')
    
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add a Question</h1>
            
          </div>
          <div class="table-responsive">
          <form method="POST" action="{{ route('add_question_post') }}">
         
          @csrf
          
            <div class="form-group">
              <label for="exampleInputEmail1">Question</label>
              <textarea class="form-control" name="question" reqiured placeholder="Enter Question here">{{ old('question') }}</textarea>
              @error('question')
                                    
                                        <strong>{{ $message }}</strong>
                                
                                @enderror
               </div>
              <div class="form-group">
                <label for="exampleSelect">Is_General</label>
                <select name="is_general" class="form-control" id="exampleSelect" required>
                 <option value="" >Is General ?</option>
                  <option value="1" >Yes</option>
                  <option value="0" >No</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInput">Category</label>
                <input type="text" name="categories" value="{{ old('categories') }}" class="form-control" id="exampleInput" required placeholder="Enter Question category">
                @error('category')
                                    
                                        <strong>{{ $message }}</strong>
                                
                @enderror
              </div>
              <div class="form-group">
                <label for="exampleInput">Point</label>
                <input type="text" name="point" value="{{ old('point') }}" class="form-control" id="exampleInput" required placeholder="Enter Question point">
                @error('point')
                                    
                                        <strong>{{ $message }}</strong>
                                
                @enderror
              </div>
              <div class="form-group">
                <label for="exampleInput">Icon-Url</label>
                <input type="text" name="icon_url" value="{{ old('icon_url') }}" class="form-control" id="exampleInput">
                @error('icon_url')
                                    
                                        <strong>{{ $message }}</strong>
                                
                                @enderror
              </div>
              <div class="form-group">
                <label for="exampleInput">Duration</label>
                <input type="text" required name="duration" value="{{ old('duration') }}" class="form-control" id="exampleInput" placeholder="Enter Question duration">
              @error('duration')
                                    
                                        <strong>{{ $message }}</strong>
                                
                                @enderror
              </div>
            <button type="submit" class="btn btn-primary">Save </button></a>
          </form>
           
          </div>
        </main>
      </div>
    </div>

@endsection