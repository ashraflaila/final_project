@extends('cms.perant')
@section('title', 'Trashed Courses')
@section('mine-title', 'Courses Management')
@section('sub-title', 'Trashed Courses')
@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white; border-radius: 0.375rem 0.375rem 0 0; padding: 1rem 1.5rem;
    }
    .card-header-gradient h3 { margin: 0; font-size: 1.1rem; font-weight: 600; letter-spacing: 0.5px; }
    .btn-add {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white; border: none; padding: 0.45rem 1.2rem;
        border-radius: 25px; font-weight: 600; font-size: 0.85rem;
        transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(245,87,108,0.4);
        text-decoration: none; display: inline-block; cursor: pointer;
    }
    .btn-add:hover { color: white; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245,87,108,0.5); text-decoration: none; }
    .table thead th {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white; font-weight: 600; font-size: 0.85rem;
        letter-spacing: 0.5px; border: none; padding: 0.9rem 1rem; text-transform: uppercase;
    }
    .table tbody tr { transition: background 0.2s ease; }
    .table tbody tr:hover { background-color: #e8fdf5 !important; }
    .table tbody td { vertical-align: middle; padding: 0.75rem 1rem; font-size: 0.9rem; color: #444; border-color: #f0f0f0; }
    .id-badge { background: #e8f4fd; color: #2980b9; padding: 0.25rem 0.6rem; border-radius: 10px; font-weight: 700; font-size: 0.8rem; }
    .btn-action { width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s ease; font-size: 0.9rem; }
    .btn-action:hover { transform: translateY(-2px); }
</style>
@endsection
@section('contents')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header-gradient d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-trash mr-2"></i> Trashed Courses</h3>
                    <div style="display:flex; gap:10px; align-items:center;">
                        <a href="{{ route('courses.index') }}" class="btn-add" style="background: #ecf0f1; color: #333;">
                            <i class="fas fa-arrow-left mr-1"></i> Back To Courses
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 60px;">ID</th>
                                    <th>Title</th>
                                    <th>Course Teacher</th>
                                    <th>Deleted At</th>
                                    <th class="text-center" style="width: 180px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                    <tr>
                                        <td class="text-center"><span class="id-badge">{{ $course->id }}</span></td>
                                        <td>{{ $course->title }}</td>
                                        <td>{{ $course->teacher->name ?? '-' }}</td>
                                        <td>{{ $course->deleted_at ? $course->deleted_at->format('Y-m-d H:i') : '-' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center" style="gap:5px;">
                                                <form action="{{ route('courses.restore', $course->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-action" style="background:#d4edda; color:#1e7e34;" title="Restore">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('courses.show', $course->id) }}" class="btn-action" style="background:#d1ecf1; color:#0c7db1;" title="Show">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('courses.force-delete', $course->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف المساق نهائياً؟');">
                                                    @csrf
                                                    <button type="submit" class="btn-action" style="background:#f8d7da; color:#b02a37;" title="Force Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No trashed courses available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection