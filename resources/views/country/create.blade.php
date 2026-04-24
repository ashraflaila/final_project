@extends('cms.perant')

@section('title', 'Create Country')
@section('mine-title', 'Countries')
@section('sub-title', 'Create New Country')

@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white; padding: 1rem 1.5rem;
        border-radius: 0.375rem 0.375rem 0 0;
    }
    .card-header-gradient h3 { margin: 0; font-size: 1.1rem; font-weight: 700; }
    .form-group label { font-weight: 600; color: #2c3e50; font-size: 0.875rem; margin-bottom: 0.4rem; }
    .form-control {
        border: 2px solid #e9ecef; /* ✅ كان مكتوب solcode */
        border-radius: 8px; padding: 0.55rem 0.85rem;
        font-size: 0.9rem; transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control:focus { border-color: #11998e; box-shadow: 0 0 0 0.2rem rgba(17,153,142,0.15); }
    .btn-save {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white; border: none; padding: 0.5rem 1.8rem;
        border-radius: 25px; font-weight: 700; transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(17,153,142,0.35);
    }
    .btn-save:hover { color: white; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(17,153,142,0.5); }
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
                    <h3><i class="fas fa-plus-circle mr-2"></i> Add New Country</h3>
                </div>
                <div class="card-body p-4">

                    {{-- ✅ عنصر الأخطاء المطلوب من crud.js --}}
                    <div id="error_alert" hidden>
                        <div class="alert alert-danger">
                            <ul id="error_messages_ul" class="mb-0"></ul>
                        </div>
                    </div>

                    {{-- ✅ أضفنا id="create_form" --}}
                    <form id="create_form" action="{{ route('countries.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="fas fa-flag mr-1 text-muted"></i> Country Name
                                    </label>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name"
                                        value="{{ old('name') }}"
                                        placeholder="e.g. Saudi Arabia" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">
                                        <i class="fas fa-tag mr-1 text-muted"></i> Country Code
                                    </label>
                                    <input type="text"
                                        class="form-control @error('code') is-invalid @enderror"
                                        id="code" name="code"
                                        value="{{ old('code') }}"
                                        placeholder="e.g. SA" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="mt-2">

                        <div class="d-flex" style="gap: 10px;">
                            <button type="button" onclick="performStore()" class="btn-save">
                                <i class="fas fa-save mr-1"></i> Store
                            </button>
                            <a href="{{ route('countries.index') }}" class="btn-back">
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
    function performStore() {
        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('code', document.getElementById('code').value);
        store('/cms/admin/countries', formData);
    }
</script>
@endsection