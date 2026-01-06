@extends('layouts.navadmin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Users /</span> Edit</h4>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <h4 class="alert-heading">Whoops! There were some problems with your input.</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit User: {{ $editUser->name }}</h5>
                <small class="text-muted float-end">User Management</small>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $editUser->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $editUser->name }}" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $editUser->email }}" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password (leave blank to keep current)</label>
                        <input type="password" class="form-control" id="password" name="password" />
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
