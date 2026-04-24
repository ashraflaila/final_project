@extends('cms.perant')

@section('title', 'Trashed Cities')

@section('mine-title', 'Cities Management')

@section('sub-title', 'Trashed Cities')

@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.375rem 0.375rem 0 0;
        padding: 1rem 1.5rem;
    }
    .card-header-gradient h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .btn-add {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
        padding: 0.45rem 1.2rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
    }
    .btn-add:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 87, 108, 0.5);
    }
    .table thead th {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border: none;
        padding: 0.9rem 1rem;
        text-transform: uppercase;
    }
    .table tbody tr {
        transition: background 0.2s ease;
    }
    .table tbody tr:hover {
        background-color: #f0f4ff !important;
    }
    .table tbody td {
        vertical-align: middle;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        color: #444;
        border-color: #f0f0f0;
    }
    .id-badge {
        background: #e8f4fd;
        color: #2980b9;
        padding: 0.25rem 0.6rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.8rem;
    }
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-size: 0.8rem;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .city-name {
        font-weight: 600;
        color: #2c3e50;
    }
</style>
@endsection

@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">

                <div class="card-header-gradient d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-trash mr-2"></i> Trashed Cities</h3>
                    <div style="display: flex; gap: 10px;">
                        <form action="{{ route('cities.restore-all') }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('هل تريد استعادة كل المدن؟')">
                            @csrf
                            <button type="submit" class="btn-add" style="background: linear-gradient(135deg, #84fab0 0%, #2ecc71 100%);">
                                <i class="fas fa-undo mr-1"></i> Restore All
                            </button>
                        </form>
                        <a href="{{ route('cities.index') }}" class="btn-add">
                            <i class="fas fa-arrow-left mr-1"></i> Back To Cities
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 60px;" class="text-center">ID</th>
                                <th class="text-center">City Name</th>
                                <th class="text-center">Street</th>
                                <th class="text-center">Country Name</th>
                                <th class="text-center" style="width: 170px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cities as $city)
                            <tr>
                                <td class="text-center">
                                    <span class="id-badge">{{ $city->id }}</span>
                                </td>
                                <td>
                                    <span class="city-name">
                                        <i class="fas fa-flag mr-1 text-muted" style="font-size:0.75rem;"></i>
                                        {{ $city->name }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $city->street }}</td>
                                <td class="text-center">{{ $city->country?->name ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: 5px;">
                                        <form action="{{ route('cities.restore.post', $city->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-action"
                                                    style="background:#d4edda; color:#1e7e34;"
                                                    title="استعادة">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>

                                        <a href="{{ route('cities.show', $city->id) }}"
                                           class="btn btn-action"
                                           style="background:#d1ecf1; color:#0c7db1;"
                                           title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <form action="{{ route('cities.force-delete', $city->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('هل تريد حذف المدينة نهائيا؟')">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-action"
                                                    style="background:#f8d7da; color:#b02a37;"
                                                    title="حذف نهائي">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">لا توجد مدن في سلة المحذوفات.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white py-3">
                    {{ $cities->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
