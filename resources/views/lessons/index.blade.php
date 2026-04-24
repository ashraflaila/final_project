@extends('cms.perant')
@section('title', 'Lessons')
@section('mine-title', 'Lessons Management')
@section('sub-title', 'All Lessons')
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
            <h3>Lessons List</h3>
            <div style="display:flex; gap:10px; align-items:center;">
                <a href="{{ route('lessons.trashed') }}" class="btn btn-add" style="background: linear-gradient(135deg, #84fab0 0%, #2ecc71 100%); color: #1a252f;">
                    View Trashed
                </a>
                <a href="{{ route('lessons.create') }}" class="btn btn-add">Add Lesson</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('lessons.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="title" class="form-label">Lesson Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ request('title') }}" placeholder="Search by lesson title">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="course_id" class="form-label">Course</label>
                        <select name="course_id" id="course_id" class="form-control">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-add mr-2">Filter</button>
                        <a href="{{ route('lessons.index') }}" class="btn btn-back">Reset</a>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Course</th>
                        <th>Duration</th>
                        <th>Video</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lessons as $lesson)
                        <tr>
                            <td>{{ $lesson->id }}</td>
                            <td>{{ $lesson->title }}</td>
                            <td>{{ optional($lesson->course)->title ?? '-' }}</td>
                            <td>{{ $lesson->duration !== null ? $lesson->duration . ' min' : '-' }}</td>
                            <td>
                                @if($lesson->video_url)
                                    <a href="{{ $lesson->video_url }}" target="_blank">Watch</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('lessons.show', $lesson->id) }}" class="btn btn-info btn-sm">Show</a>
                                <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $lessons->links() }}
        </div>
    </div>
</div>
</div>
@endsection
