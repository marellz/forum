@extends('wrappers.main')
@section('content')
<div class="section pd-2">

  <div class="container form">
    <div class="container-header">
      <h1 class="typ title">Create a Thread</h1>
    </div>
    <div class="container-body">
      <form method="post" action="{{route('create-thread')}}">
        {{csrf_field()}}
        <div class="row">
          <div class="input">
            <input name="title" required/>
            <label>Thread Title</label>
          </div>

          <div class="input textarea">
            <textarea name="content" required></textarea>
            <label>Thread Content</label>
          </div>

          <div class="pd-s buttons">
            <button>Create</button>
          </div>

        </div>
      </form>
    </div>
  </div>

</div>
@endsection
