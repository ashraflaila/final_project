@extends('cms.perant')
@section('title', 'Courses')
@section('mine-title', 'Courses Management')
@section('sub-title', 'All Courses')
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
</style>
@endsection
@section('contents')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header-gradient d-flex justify-content-between align-items-center">
            <h3>Courses List</h3>
            <div style="display:flex; gap:10px; align-items:center;">
                <a href="{{ route('courses.trashed') }}" class="btn btn-add" style="background: linear-gradient(135deg, #84fab0 0%, #2ecc71 100%); color: #1a252f;">
                    View Trashed
                </a>
                @can('create-course')
                <a href="{{ route('courses.create') }}" class="btn btn-add">Add Course</a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('courses.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">Course Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}" placeholder="Search by course name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="teacher_id" class="form-label">Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="form-control">
                            <option value="">All Teachers</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-add mr-2">Filter</button>
                        <a href="{{ route('courses.index') }}" class="btn btn-back">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Teacher</th>
                        <th>Lessons Count</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->price !== null ? number_format($course->price, 2) : '-' }}</td>
                            <td>{{ optional($course->teacher)->name ?? 'غير متوفر' }}</td>
                            <td>{{ $course->lessons_count }}</td>
                            <td>{{ optional($course->category)->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info btn-sm">Show</a>
                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                @can('delete-course')
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

            <div class="mt-3">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</div>
</div>
@endsection
