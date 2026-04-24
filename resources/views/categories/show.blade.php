@extends('cms.perant')

@section('title', 'Show Category')
@section('mine-title', 'Categories')
@section('sub-title', 'Category Details')

@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white; padding: 1rem 1.5rem; border-radius: 0.375rem 0.375rem 0 0;
    }
    .card-header-gradient h3 { margin: 0; font-size: 1.1rem; font-weight: 700; }
    .card { border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-radius: 10px; }
    .detail-label { font-weight: 700; color: #7f8c8d; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.3rem; }
    .detail-value { font-size: 1rem; font-weight: 600; color: #2c3e50; padding: 0.6rem 1rem; background: #f8f9fa; border-radius: 8px; border: 2px solid #e9ecef; }
    .btn-back { background: #ecf0f1; color: #555; border: none; padding: 0.5rem 1.5rem; border-radius: 25px; font-weight: 600; transition: all 0.3s ease; text-decoration: none; display: inline-block; }
    .btn-back:hover { background: #d5d8dc; color: #333; text-decoration: none; }
    .btn-edit { background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%); color: #2c3e50; border: none; padding: 0.5rem 1.5rem; border-radius: 25px; font-weight: 700; transition: all 0.3s ease; text-decoration: none; display: inline-block; box-shadow: 0 4px 15px rgba(247,151,30,0.3); }
    .btn-edit:hover { color: #1a252f; transform: translateY(-2px); text-decoration: none; }
    .id-badge { background: #e8f4fd; color: #2980b9; padding: 0.3rem 0.7rem; border-radius: 10px; font-weight: 700; font-size: 0.85rem; display: inline-block; }
    .description-box { background: #f0fdf9; border: 2px solid #a7f3d0; border-radius: 10px; padding: 1rem 1.2rem; color: #065f46; font-size: 0.95rem; line-height: 1.7; white-space: pre-line; }
</style>
@endsection

@section('contents')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header-gradient">
                    <h3><i class="fas fa-tags mr-2"></i> Category Details</h3>
                </div>
                <div class="card-body p-4">

                    {{-- Top Row --}}
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-2">
                            <div class="detail-label">ID</div>
                            <div class="detail-value"><span class="id-badge">#{{ $category->id }}</span></div>
                        </div>
                        <div class="col-md-10">
                            <div class="detail-label"><i class="fas fa-tag mr-1"></i> Name</div>
                            <div class="detail-value">{{ $category->name }}</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="detail-label"><i class="fas fa-list mr-1"></i> Courses Count</div>
                            <div class="detail-value">{{ $category->courses_count }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label"><i class="fas fa-toggle-on mr-1"></i> Status</div>
                            <div class="detail-value">{{ $category->status ?? 'Inactive' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label"><i class="fas fa-calendar-plus mr-1"></i> Created At</div>
                            <div class="detail-value" style="font-size:0.85rem;">{{ $category->created_at ? $category->created_at->format('Y-m-d H:i') : 'N/A' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label"><i class="fas fa-info-circle mr-1"></i> Soft Delete Status</div>
                            <div class="detail-value">
                                @if($category->deleted_at)
                                    <span style="background:linear-gradient(135deg,#ff9a9e,#f6416c);color:white;padding:0.3rem 0.8rem;border-radius:15px;font-size:0.8rem;font-weight:700;">
                                        <i class="fas fa-trash mr-1"></i> Trashed
                                    </span>
                                @else
                                    <span style="background:linear-gradient(135deg,#84fab0,#2ecc71);color:white;padding:0.3rem 0.8rem;border-radius:15px;font-size:0.8rem;font-weight:700;">
                                        <i class="fas fa-check mr-1"></i> Active
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($category->description)
                    <div class="mb-4">
                        <div class="detail-label mb-2"><i class="fas fa-align-left mr-1"></i> Description</div>
                        <div class="description-box">{{ $category->description }}</div>
                    </div>
                    @endif

                    <hr>

                    <div class="d-flex" style="gap: 10px;">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn-edit">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left mr-1"></i> Go Back
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
