@extends('cms.perant')

@section('title', 'Edit City')
@section('mine-title', 'Cities')
@section('sub-title', 'Edit City Details')

@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
        color: #2c3e50; padding: 1rem 1.5rem;
        border-radius: 0.375rem 0.375rem 0 0;
    }
    .card-header-gradient h3 { margin: 0; font-size: 1.1rem; font-weight: 700; }
    .form-group label { font-weight: 600; color: #2c3e50; font-size: 0.875rem; margin-bottom: 0.4rem; }
    .form-control {
        border: 2px solid #e9ecef; border-radius: 8px;
        padding: 0.55rem 0.85rem; font-size: 0.9rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control:focus { border-color: #f7971e; box-shadow: 0 0 0 0.2rem rgba(247,151,30,0.15); }
    .btn-update {
        background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
        color: #2c3e50; border: none; padding: 0.5rem 1.8rem;
        border-radius: 25px; font-weight: 700; transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(247,151,30,0.35); cursor: pointer;
    }
    .btn-update:hover { color: #1a252f; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(247,151,30,0.5); }
    .btn-back {
        background: #ecf0f1; color: #555; border: none;
        padding: 0.5rem 1.5rem; border-radius: 25px; font-weight: 600;
        transition: all 0.3s ease; text-decoration: none; display: inline-block;
    }
    .btn-back:hover { background: #d5d8dc; color: #333; text-decoration: none; }
    .card { border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-radius: 10px; }
</style>
@endsection

@section('contents')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header-gradient">
                    <h3><i class="fas fa-edit mr-2"></i> Edit City</h3>
                </div>
                <div class="card-body p-4">

                    {{-- ✅ عنصر الأخطاء --}}
                    <div id="error_alert" hidden>
                        <div class="alert alert-danger">
                            <ul id="error_messages_ul" class="mb-0"></ul>
                        </div>
                    </div>

                    {{-- ✅ كل الحقول جوّا الـ form --}}
                    <form id="create_form" action="{{ route('cities.update', $cities->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- ✅ Country مع selected على البلد الحالية --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" id="country_id" name="country_id" style="width: 100%;">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ $cities->country_id == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- ✅ القيم من $cities مش old() --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="fas fa-flag mr-1 text-muted"></i> City Name
                                    </label>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name"
                                        value="{{ old('name', $cities->name) }}"
                                        placeholder="e.g. Riyadh" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="street">
                                        <i class="fas fa-tag mr-1 text-muted"></i> City Street
                                    </label>
                                    <input type="text"
                                        class="form-control @error('street') is-invalid @enderror"
                                        id="street" name="street"
                                        value="{{ old('street', $cities->street) }}"
                                        placeholder="e.g. Main St" required>
                                    @error('street')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="mt-2">

                        <div class="d-flex" style="gap: 10px;">
                            <button type="button" onclick="performUpdate({{ $cities->id }})" class="btn-update">
                                <i class="fas fa-save mr-1"></i> Update
                            </button>
                            <a href="{{ route('cities.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left mr-1"></i> Go Back
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function performUpdate(id) {
        let data = {
            _token:     document.querySelector('input[name="_token"]').value,
            name:       document.getElementById('name').value,
            street:     document.getElementById('street').value,
            country_id: document.getElementById('country_id').value,
        };

        updateRoute('/cms/admin/cities-update/' + id, data);
    }
</script>
@endsection
