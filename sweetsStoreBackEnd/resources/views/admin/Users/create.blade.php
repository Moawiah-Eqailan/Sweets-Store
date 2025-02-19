@extends('layouts.app')

@section('title', 'Create Users')

@section('contents')
<hr />
<form action="{{ route('Users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <!-- <div class="col">
                <input type="text" name="id" class="form-control" placeholder="id">
            </div> -->
        <div class="col">
            <input type="text" name="name" class="form-control" placeholder="name">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <input type="text" name="email" class="form-control" placeholder="email">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
    </div>


    <div class="row">
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection