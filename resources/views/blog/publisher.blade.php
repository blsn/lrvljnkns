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
                    <h3 class="card-text">Blog posts management</h3>

                    @if (count($posts) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 50%">Title</th>
                                <th style="width: 30%">By</th>
                                <th style="width: 10%">Edit</th>
                                <th style="width: 10%">Delete</th>
                            </tr>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{$post->title}}</td>
                                    <td>{{$post->user->name}}</td>
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
