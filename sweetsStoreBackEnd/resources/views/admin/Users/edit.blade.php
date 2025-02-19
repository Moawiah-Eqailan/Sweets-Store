@extends('layouts.app')

@section('title', 'Edit User')

@section('contents')
<hr />
<form action="{{ route('Users.update', $users->id) }}" method="POST">

    @csrf
    @method('PUT')
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Id</label>
            <input type="text" name="id" class="form-control" placeholder="id" value="{{ $users->id }}">
        </div>
        <div class="col mb-3">
            <label class="form-label">name</label>
            <input type="text" name="name" class="form-control" placeholder="name" value="{{ $users->name }}">
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">email</label>
            <input type="text" name="email" class="form-control" placeholder="email" value="{{ $users->email }}">
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" placeholder="Created At" value="{{ $users->created_at }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Updated At" value="{{ $users->updated_at }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="d-grid">
            <button class="btn btn-warning">Update</button>
        </div>
    </div>
</form>
@endsection