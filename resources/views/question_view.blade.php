@extends('layouts.base')
@section('content')
    
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Question & Choices</h1>
            
          </div>

          <h4>Question: {{ $question->question }}</h4>
          <table class="table table-striped table-sm">
          <tr>
            <td>Is_General : {{ $question->is_general ==1 ? 'TRUE' : 'FALSE' }}</td>
             <td>Category : {{ $question->categories }}</td>
            <td>Point : {{ $question->point }}</td>
             <td>Icon Url : {{ $question->icon_url }}</td>
            <td>Duration : {{ $question->duration }}</td>
          </tr>
           <tr>
            <td><button type="button" class="btn btn-primary">Edit Qustion</button></td>
             <td><button type="button" class="btn btn-danger">Delete Qustion</button></td>
            <td colspan="3"><button type="button" class="btn btn-primary">Add new Choice</button></td>
        
          </tr>
          </table>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
              <tr>
                  <th colspan="6">List of Choices</th>
            
                </tr>
                <tr>
                  <th>#</th>
                  <th>Description</th>
                  <th>Is Correct Choice ?</th>
                  <th>Icon Url</th>
                  <th>Action</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @if($choices->count())
                <?php $sn=0; ?>
                @foreach ( $choices as $choice )
                 <?php $sn++; ?>
                  <tr>
                  <td>{{ $sn }}</td>
                  <td>{{ $choice->description }}</td>
                  <td>{{ $choice->is_correct_choice==1 ? 'TRUE':'FALSE' }}</td>
                  <td>{{ $choice->icon_url }}</td>
                  <td><button type="button" class="btn btn-primary">Edit</button></td>
                  <td><button type="button" class="btn btn-danger">Delete</button></td>
                </tr>
                @endforeach
        
                @endif
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

@endsection