@extends('cms.perant')

@section('title', 'Trashed Categories')
@section('mine-title', 'Categories Management')
@section('sub-title', 'Trashed Categories')

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
    .name-badge { background: linear-gradient(135deg, #11998e, #38ef7d); color: white; padding: 0.35rem 0.75rem; border-radius: 15px; font-size: 0.78rem; font-weight: 700; letter-spacing: 0.3px; display: inline-block; }
    .id-badge { background: #e8f4fd; color: #2980b9; padding: 0.25rem 0.6rem; border-radius: 10px; font-weight: 700; font-size: 0.8rem; }
    .btn-action { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s ease; font-size: 0.8rem; }
    .btn-action:hover { transform: translateY(-2px); }
    .deleted-at-badge { background: #fff3cd; color: #856404; padding: 0.25rem 0.6rem; border-radius: 8px; font-size: 0.78rem; font-weight: 600; }
</style>
@endsection

@section('contents')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">

                <div class="card-header-gradient d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-trash mr-2"></i> Trashed Categories</h3>
                    <div style="display: flex; gap: 10px;">
                        <form action="{{ route('categories.restore-all') }}" method="POST" class="d-inline"
                              onsubmit="return confirm('هل تريد استعادة كل الأقسام؟')">
                            @csrf
                            <button type="submit" class="btn-add" style="background: linear-gradient(135deg, #84fab0 0%, #2ecc71 100%); color: #1a252f;">
                                <i class="fas fa-undo mr-1"></i> Restore All
                            </button>
                        </form>
                        <a href="{{ route('categories.index') }}" class="btn-add">
                            <i class="fas fa-arrow-left mr-1"></i> Back To Categories
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 60px;" class="text-center">ID</th>
                                <th>Name</th>
                                <th class="text-center">Deleted At</th>
                                <th class="text-center" style="width: 170px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                            <tr>
                                <td class="text-center">
                                    <span class="id-badge">{{ $category->id }}</span>
                                </td>
                                <td>
                                    <span class="name-badge">
                                        <i class="fas fa-tag mr-1"></i> {{ $category->name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="deleted-at-badge">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $category->deleted_at ? $category->deleted_at->format('Y-m-d H:i') : '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: 5px;">
                                        <form action="{{ route('categories.restore', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-action" style="background:#d4edda; color:#1e7e34;" title="استعادة">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-action" style="background:#d1ecf1; color:#0c7db1;" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('categories.force-delete', $category->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete permanently?')">
                                            @csrf
                                            <button type="submit" class="btn btn-action" style="background:#f8d7da; color:#b02a37;" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="fas fa-check-circle text-success mr-2" style="font-size:1.3rem;"></i>
                                    There are no categories in trash.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white py-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
