@extends('cms.perant')

@section('title', 'Countries')

@section('mine-title', 'Countries Management')

@section('sub-title', 'All Countries')

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
    .badge-code {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 15px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1px;
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
    .country-name {
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

                {{-- Card Header --}}
                <div class="card-header-gradient d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-globe-americas mr-2"></i> Countries List</h3>
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('countries.create') }}" class="btn-add">
                            <i class="fas fa-plus mr-1"></i> Add New Country
                        </a>
                        <form action="{{ route('countries.delete-all') }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('هل تريد حذف كل الدول؟')">
                            @csrf
                            <button type="submit" class="btn-add" style="background: linear-gradient(135deg, #ff9a9e 0%, #f6416c 100%);">
                                <i class="fas fa-trash-alt mr-1"></i> Delete All
                            </button>
                        </form>
                        <a href="{{ route('countries.trashed') }}" class="btn-add">
                            <i class="fas fa-trash mr-1"></i> View Trashed Countries
                        </a>
                    </div>
                </div>

                {{-- Table --}}
                <div class="card-body p-0">
                    <form action="{{ route('countries.index') }}" method="GET" class="p-3 border-bottom">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="name" class="form-label">Country Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}" placeholder="Search by country name">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="code" class="form-label">Country Code</label>
                                <input type="text" name="code" id="code" class="form-control" value="{{ request('code') }}" placeholder="Search by code">
                            </div>
                            <div class="col-md-2 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn-add mr-2">Filter</button>
                                <a href="{{ route('countries.index') }}" class="btn btn-light">Reset</a>
                            </div>
                        </div>
                    </form>
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 60px;" class="text-center">ID</th>
                                <th>Country Name</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Number of Cities</th>
                                <th class="text-center" style="width: 130px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countries as $country)
                            <tr>
                                <td class="text-center">
                                    <span class="id-badge">{{ $country->id }}</span>
                                </td>
                                <td>
                                    <span class="country-name">
                                        <i class="fas fa-flag mr-1 text-muted" style="font-size:0.75rem;"></i>
                                        {{ $country->name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge-code">{{ $country->code }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('cities.index', ['country_id' => $country->id]) }}" class="badge-code d-inline-block">
                                        {{ $country->cities_count }}
                                    </a>
                                </td>
                                <td class="text-center">

                                    <div class="d-flex justify-content-center" style="gap: 5px;">

                                        {{-- Show --}}
                                        <a href="{{ route('countries.show', $country->id) }}"
                                           class="btn btn-action"
                                           style="background:#d1ecf1; color:#0c7db1;"
                                           title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('countries.edit', $country->id) }}"
                                           class="btn btn-action"
                                           style="background:#fff3cd; color:#c9860c;"
                                           title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('countries.delete', $country->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-action"
                                                    style="background:#f8d7da; color:#b02a37;"
                                                    title="حذف">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="card-footer bg-white py-3">
                    {{ $countries->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
