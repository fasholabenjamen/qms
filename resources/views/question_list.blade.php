@extends('layouts.base')
@section('content')
    
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Questions</h1>
          </div>
        <div style="color:green;"><h4>
          @if(session('errors'))
                  @foreach ($errors as $error)
                      <li>{{ $error }}</li>
                  @endforeach
                @endif
                @if(session('success'))
                 {{ session('success') }}
            @endif </h4>
          </div>
          <h3>List of Questions</h3>
          <div class="row">
            <div class="form-group col-4">
              <label for="exampleSelectMultiple">Sort by Category</label>
              <select name="cat" class="form-control " id="cat">
                @if($categories)
                    <option value="">Select Category</option>
                  @foreach ($categories as $category )
                      <option value="{{ $category->categories }}">{{ $category->categories }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group col-2">
              <label for="exampleSelectMultiple"></label>
              <button type="button" onclick="sort();" class="btn btn-primary form-control">Sort</button>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Question</th>
                  <th>Is_General</th>
                  <th>Category</th>
                  <th>Point</th>
                  <th>Icon Url</th>
                  <th>Duration</th>
                  <th>Action</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
               @if($questions->count())
                {{ $questions->links() }}
                <?php $sn=1 ?>
                @foreach ($questions as $question )
                <tr>
                  <td>{{ $sn }}</td>
                  <td>{{ $question->question }}</td>
                  <td>{{ $question->is_general ==1 ? 'TRUE' : 'FALSE'}}</td>
                  <td>{{ $question->categories }}</td>
                  <td>{{ $question->point }}</td>
                  <td>{{ $question->icon_url }}</td>
                  <td>{{ $question->duration }}</td>
                  <td><a href="{{ route('question.show',$question->id) }}"> <button type="button" class="btn btn-primary">View</button></a></td>
                  <td><form action="{{ route('question.destroy',$question->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete?')">
                @method('DELETE') @csrf 
                <input type="submit" class="btn btn-danger" value="Delete" />
             </form>
                  </td>
                </tr>
                <?php $sn++ ?>
                @endforeach
               @else
               <tr>
                  <td colspan="9">No Question Available</td>
                </tr>
               @endif
              </tbody>
            </table>
            @if($questions->count())
             {{ $questions->links() }}
            @endif
          </div>
        </main>
      </div>
    </div>
<script>
function sort(){
  var cat=document.getElementById('cat').value;
  if(cat==''){
    window.location="{{ route('question.index') }}";
    return;
  }
  window.location="/question/sort/"+cat;
}
</script>
@endsection