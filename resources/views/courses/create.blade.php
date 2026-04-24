@extends('cms.perant')
@section('title', 'Create Course')
@section('mine-title', 'Courses Management')
@section('sub-title', 'Create New Course')
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
    .table thead th {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white; font-weight: 600; font-size: 0.85rem; border: none;
        padding: 0.9rem 1rem; text-transform: uppercase;
    }
    .table tbody tr:hover { background-color: #e8fdf5 !important; }
    .form-group label { font-weight: 600; }
</style>
@endsection
@section('contents')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header-gradient">
            <h3>Add New Course</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" step="0.01" min="0" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Teacher</label>
                    <select name="teacher_id" class="form-control" required>
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">No Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-save">Save</button>
                <a href="{{ route('courses.index') }}" class="btn btn-back">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection