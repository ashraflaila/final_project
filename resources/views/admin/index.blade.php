@extends('cms.perant')

@section('title', 'Admins')

@section('mine-title', 'Admins Management')

@section('sub-title', 'All Admins')

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
        white-space: nowrap;
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
        white-space: nowrap;
    }
    .id-badge {
        background: #e8f4fd;
        color: #2980b9;
        padding: 0.25rem 0.6rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.8rem;
    }
    .admin-name {
        font-weight: 600;
        color: #2c3e50;
    }
    .info-badge {
        display: inline-block;
        padding: 0.3rem 0.7rem;
        border-radius: 12px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .gender-badge {
        background: #eef2ff;
        color: #4f46e5;
        text-transform: lowercase;
    }
    .status-badge {
        text-transform: lowercase;
    }
    .status-active {
        background: #d1fae5;
        color: #047857;
    }
    .status-inactive {
        background: #fee2e2;
        color: #b91c1c;
    }
    .country-badge {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .settings-group {
        display: flex;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .btn-setting {
        border: none;
        border-radius: 4px;
        padding: 0.28rem 0.7rem;
        color: white;
        font-size: 0.78rem;
        font-weight: 600;
        line-height: 1.4;
    }
    .btn-setting:hover {
        color: white;
        opacity: 0.92;
    }
    .btn-show {
        background: #28a745;
    }
    .btn-edit {
        background: #17a2b8;
    }
    .btn-delete {
        background: #dc3545;
    }
</style>
@endsection

@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">

                <div class="card-header-gradient d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-user-shield mr-2"></i> Admins List</h3>
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('admins.create') }}" class="btn-add">
                            <i class="fas fa-plus mr-1"></i> Create New Admin
                        </a>
                        <form action="{{ route('admins.delete-all') }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete all admins?')">
                            @csrf
                            <button type="submit" class="btn-add" style="background: linear-gradient(135deg, #ff9a9e 0%, #f6416c 100%);">
                                <i class="fas fa-trash-alt mr-1"></i> Delete All
                            </button>
                        </form>
                        <a href="{{ route('admins.trashed') }}" class="btn-add">
                            <i class="fas fa-trash mr-1"></i> View Trashed Admins
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <form action="{{ route('admins.index') }}" method="GET" class="p-3 border-bottom">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Admin Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}" placeholder="Search by name">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="country_id" class="form-label">Country</label>
                                <select name="country_id" id="country_id" class="form-control">
                                    <option value="">All Countries</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">All</option>
                                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn-add mr-2">Filter</button>
                                <a href="{{ route('admins.index') }}" class="btn btn-light">Reset</a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;" class="text-center">ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th class="text-center">Gender</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Country Name</th>
                                    <th class="text-center" style="width: 220px;">Setting</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($admins as $admin)
                                <tr>
                                    <td class="text-center">
                                        <span class="id-badge">{{ $admin->id }}</span>
                                    </td>
                                    <td>
                                        <span class="admin-name">{{ $admin->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="admin-name">{{ $admin->last_name ?? '-' }}</span>
                                    </td>
                                    <td>{{ $admin->email ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="info-badge gender-badge">
                                            {{ strtolower($admin->gender ?? 'male') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="info-badge status-badge {{ strtolower($admin->status ?? 'Inactive') === 'active' ? 'status-active' : 'status-inactive' }}">
                                            {{ strtolower($admin->status ?? 'inactive') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="info-badge country-badge">
                                            {{ $admin->country?->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="settings-group">
                                            <a href="{{ route('admins.edit', $admin->id) }}" class="btn-setting btn-edit">
                                                Edit
                                            </a>

                                            <form action="{{ route('admins.delete', $admin->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-setting btn-delete">
                                                    Delete
                                                </button>
                                            </form>

                                            <a href="{{ route('admins.show', $admin->id) }}" class="btn-setting btn-show">
                                                Show
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        There are no Admins yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white py-3">
                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
