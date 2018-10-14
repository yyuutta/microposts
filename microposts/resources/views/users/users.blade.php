@if (count($users) > 0)
{!! Form::open(['route' => ['users.download', Auth::user()->id]]) !!}
    {!! Form::submit('Users dawnload', ['class' => 'btn btn-primary btn-default']) !!}
{!! Form::close() !!}
{!! $users->render() !!}
<ul class="media-list">
@foreach ($users as $user)
    <li class="media">
        <div class="media-left">
            <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
        </div>
        <div class="media-body">
            <div>
                {{ $user->name }}
            </div>
            <div>
                <p>{!! link_to_route('users.show', 'profile', ['id' => $user->id]) !!}</p>
            </div>
        </div>
    </li>
@endforeach
</ul>
@endif