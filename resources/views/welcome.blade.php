@extends('wrappers.main')
@section('content')
<div class="section align home-banner">
  <div class="row -c">
    <h1 class="typ banner-title c thin">Welcome to the forums!</h1>
    <div class="pd-xs-v col-8">
      <p class="typ c">
        Here in the forums you'll be able to easily create and manage categories and topics to share with the community! Create and share your thoughts, views and opinions.
      </p>
    </div>
    <div class="row buttons">
      @if(Auth::check())
      <a class="button" href="{{route('create-thread')}}">Create</a>
      @else
      <a class="button" href="{{route('login')}}">Login</a>
      @endif
    </div>
  </div>
</div>

<div class="section pd-2">
  @if(count($threads))
  <div class="row threads">
    @foreach($threads as $thread)
    <a class="container thread-preview" href="{{route('view-thread',['code'=>$thread->code])}}">
      <div class="container-header accent">
        <h1 class="typ title">{{$thread->title}}</h1>
        <div class="container-actions">
          <span></span>
        </div>
      </div>

      <div class="container-body no-pd">
        <div class="thread-content">
          <p class="typ thick">
            {{$thread->content}}
          </p>
        </div>
        <div class="thread-stats">
          <span class="typ icon ion-md-undo">{{$thread->reply_count}} <span class="txt non-mobile-only">{{$thread->reply_count == 1 ? 'reply' : 'replies'}}</span></span>
          <span class="typ icon ion-md-eye">12 <span class="txt non-mobile-only">views</span></span>
          <span class="typ icon ion-md-heart {{$thread->liked ? 'liked' : ''}}">{{$thread->likes}} <span class="txt non-mobile-only">{{$thread->likes == 1 ? 'like' : 'likes'}}</span></span>
        </div>
      </div>

    </a>
    @endforeach
  </div>
  @else
  <div class="pd">
    <h1 class="typ thin c">No threads have been created</h1>
    <p class="typ c">
       for the moment.
    </p>
  </div>
  @endif
</div>
@endsection
