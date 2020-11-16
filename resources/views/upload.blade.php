@extends('layouts.base')
@section('content')
    
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Upload</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              
            </div>
            
          </div>
          <div class="row jumbotron">
            <div class="col-8">
              <form action="{{ route('question.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
                <div class="form-group">
                  <label for="file_upload">Select Excel File</label>
                  <input type="file" class="form-control-file" accept=".csv,.xls,.xlsx" name="file" required id="file_upload">
                </div>
                @if(session('errors'))
                  @foreach ($errors as $error)
                      <li>{{ $error }}</li>
                  @endforeach
                @endif
                @if(session('success'))
                 <li>{{ session('success') }}</li>
                @endif
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        
        </main>
      </div>
    </div>

@endsection