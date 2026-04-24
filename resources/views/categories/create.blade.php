@extends('cms.perant')
@section('title', 'Create Category')
@section('mine-title', 'Categories Management')
@section('sub-title', 'Create New Category')
@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        border-radius: 0.375rem 0.375rem 0 0;
        padding: 1rem 1.5rem;
    }
    .card-header-gradient h3 { margin: 0; font-size: 1.1rem; font-weight: 600; letter-spacing: 0.5px; }
    .btn-save, .btn-update, .btn-add {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white; border: none; padding: 0.45rem 1.2rem;
        border-radius: 25px; font-weight: 600; font-size: 0.9rem;
        transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(245,87,108,0.4);
        text-decoration: none; display: inline-block;
    }
    .btn-save:hover, .btn-update:hover, .btn-add:hover { color: white; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245,87,108,0.5); }
    .btn-back {
        background: #ecf0f1; color: #555; border: none; padding: 0.45rem 1.2rem;
        border-radius: 25px; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease;
        text-decoration: none; display: inline-block;
    }
    .btn-back:hover { background: #d5d8dc; color: #333; text-decoration: none; }
    .form-group label { font-weight: 600; }
</style>
@endsection
@section('contents')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header-gradient">
            <h3>Add New Category</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-save">Save</button>
                <a href="{{ route('categories.index') }}" class="btn btn-back">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection