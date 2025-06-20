@extends('layouts.app')

@section('title', 'Following')
    
@section('content')
  @include('users.profile.header')
    
  <div class="row" style="margin-top: 100px;">
    @if ($user->following->isNotEmpty())


      <div class="row justify-content-center">
        <div class="col-4">
          <h3 class="text-muted text-center">Following</h3>

          @foreach ($user->following as $followedUser)
            <div class="row align-items-center mt-3">
              <div class="col-auto">
                <a href="{{ route('profile.show', $followedUser->following->id) }}">
                  @if ($followedUser->following->avatar)
                    <img src="{{ $followedUser->following->avatar }}" alt="{{ $followedUser->following->name }}" class="rounded-circle avatar-sm">
                  @else
                      <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                  @endif
                </a>
              </div>
              <div class="col ps-0 text-trunccate">
                <a href="{{ route('profile.show', $followedUser->following->id) }}" class="text-decoration-none text-dark fw-bold">{{ $followedUser->following->name }}</a>
              </div>
              <div class="col-auto text-end">
                @if ($followedUser->following->id != Auth::user()->id)
                    @if ($followedUser->following->isFollowed() )
                      <form action="{{ route('follow.destroy', $followedUser->following->id ) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="border-0 bg-transparent p-0 text-secondary btn-sm">Following</button>
                      </form>
                    @else
                      <form action="{{ route('follow.store', $followedUser->following->id) }}" method="post">
                        @csrf
                        <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                      </form>
                    @endif
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>



    @else
        <h3 class="text-secondary text-center">No Following</h3>
    @endif
  </div>
@endsection