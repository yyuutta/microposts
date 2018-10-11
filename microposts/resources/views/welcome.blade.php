@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="row">
            <aside class="col-xs-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $user->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <img class="media-object img-rounded img-responsive" src="{{ Gravatar::src($user->email, 100) }}" alt="">
                    </div>
                </div>
            </aside>
            <div class="col-xs-8">
                @if (Auth::id() == $user->id)
                      {!! Form::open(['route' => 'microposts.store']) !!}
                          <div class="form-group">
                              {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2']) !!}
                              {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
                          </div>
                      {!! Form::close() !!}
                @endif
                @if (count($microposts) > 0)
                    @include('microposts.microposts', ['microposts' => $microposts])
                @endif
            </div>
        </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Microposts</h1>
                {!! link_to_route('signup.get', 'Sign up now!', null, ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection