@extends('layouts.base')
@section('content')
    
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              
            </div>
          </div>
          <div class="jumbotron">
            <h1 class="display-4">QMS</h1>
            <p class="lead">Welcome to Question Management System, {{ $no_of_questions }} questions available in the database</p>
            <hr class="my-4">
            <p>Click below to see list of available Question</p>
            <a class="btn btn-primary btn-lg" href="{{ route('question.index') }}" role="button">Show Qestions</a>
          </div>
        </main>
      </div>
    </div>

@endsection