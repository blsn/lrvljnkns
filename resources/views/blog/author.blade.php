@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Articles</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p><a class="btn btn-primary" href="/posts/create">Create post</a></p> 
                    <h3 class="card-text">Your blog posts</h3>

                    @if (count($posts) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th class="col-6">Title</th>
                                <th class="col-3">Edit</th>
                                <th class="col-3">Delete</th>
                            </tr>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{$post->title}}</td>
                                    <td><a href="/posts/{{$post->id}}/edit" class="btn btn-secondary">Edit</a></td>
                                    <td>
                                        {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!! Form::close() !!}                                        
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        @else
                        <p>You have no posts</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
