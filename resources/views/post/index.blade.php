@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">All Posts <a href="{{ route('posts.create') }}" class="btn btn-success float-right">Add posts</a> </div>
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category Name</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th>Is Image Only</th>
                                <th>Image</th>
                                <th>Youtube</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->body }}</td>
                                    <td>{{ $post->is_image_only ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <img src="{{ $post->image }}" alt="Image" width="50px"/>
                                    </td>
                                    <td style="word-break: break-all;">
                                        <iframe width="100" height="100" src="{{ $post->youtube_link }}"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                    </td>
                                    <td>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection