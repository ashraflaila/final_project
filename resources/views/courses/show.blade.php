@extends('cms.perant')
@section('title', 'Show Course')
@section('mine-title', 'Courses Management')
@section('sub-title', 'Course Details')
@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        border-radius: 0.375rem 0.375rem 0 0;
        padding: 1rem 1.5rem;
    }
    .card-header-gradient h3 { margin: 0; font-size: 1.1rem; font-weight: 600; letter-spacing: 0.5px; }
    .detail-label { font-weight: 700; color: #7f8c8d; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem; }
    .detail-value { font-size: 1rem; font-weight: 600; color: #2c3e50; padding: 0.75rem 1rem; background: #f8f9fa; border-radius: 10px; border: 1px solid #e9ecef; }
    .btn-back, .btn-edit { border-radius: 25px; padding: 0.5rem 1.4rem; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-block; }
    .btn-back { background: #ecf0f1; color: #555; }
    .btn-back:hover { background: #d5d8dc; color: #333; }
    .btn-edit { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
    .btn-edit:hover { transform: translateY(-2px); }
    .description-box { background: #f0fdf9; border: 1px solid #a7f3d0; border-radius: 10px; padding: 1rem 1.2rem; color: #065f46; line-height: 1.7; white-space: pre-line; }
</style>
@endsection
@section('contents')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header-gradient">
                    <h3>Course Details</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="detail-label">ID</div>
                            <div class="detail-value">#{{ $course->id }}</div>
                        </div>
                        <div class="col-md-9">
                            <div class="detail-label">Title</div>
                            <div class="detail-value">{{ $course->title }}</div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="detail-label">Price</div>
                            <div class="detail-value">{{ $course->price !== null ? number_format($course->price, 2) : '-' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Teacher</div>
                            <div class="detail-value">{{ $course->teacher->name ?? '-' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Category</div>
                            <div class="detail-value">{{ $course->category->name ?? '-' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">{{ $course->status ?? 'Active' }}</div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="detail-label">Description</div>
                        <div class="description-box">{{ $course->description ?? 'No description available.' }}</div>
                    </div>
                    <div class="d-flex" style="gap: 10px;">
                        <a href="{{ route('courses.edit', $course->id) }}" class="btn-edit">Edit</a>
                        <a href="{{ route('courses.index') }}" class="btn-back">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection