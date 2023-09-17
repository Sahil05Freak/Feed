@extends('layouts.app')

@section('content')
<style>
    #heading {
        display: inline-block;
    }
</style>
<div class="container">
    <div id="heading">
        <h3>Feed</h3>
    </div>
    <div id="heading" style="float:right">
        <a href="{{ url('/feeds/create') }}"><button class="btn btn-dark">+ Add Feed</button></a>
    </div>
    <br>
    <br>
    <div class="row">
        @foreach ($images as $image)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset($image->image_path) }}" class="card-img-top" alt="{{ $image->title }}">
                <div class="card-body">
                    <h4 class="card-title">{{ $image->title }}</h4><br>
                    <p class="card-text">{{ $image->description }}</p><br>
                    <p class="card-text"><small class="text-muted">Posted on {{date('d-m-Y H:i:s', strtotime($image->created_at))}}</small></p>
                    <div class="text-end">
                        <a href="{{ route('feeds.edit', $image->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('feeds.destroy', $image->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this image?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection