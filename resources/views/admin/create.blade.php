@extends('cms.perant')

@section('title', 'Create Admin')
@section('mine-title', 'Admins Management')
@section('sub-title', 'Create New Admin')

@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.375rem 0.375rem 0 0;
    }
    .card-header-gradient h3 { margin: 0; font-size: 1.1rem; font-weight: 700; }
    .form-group label { font-weight: 600; color: #2c3e50; font-size: 0.875rem; margin-bottom: 0.4rem; }
    .form-control, .custom-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.55rem 0.85rem;
        font-size: 0.9rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control:focus, .custom-select:focus {
        border-color: #11998e;
        box-shadow: 0 0 0 0.2rem rgba(17,153,142,0.15);
    }
    .section-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }
    .btn-save {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white; border: none; padding: 0.5rem 1.8rem;
        border-radius: 25px; font-weight: 700; transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(17,153,142,0.35); cursor: pointer;
    }
    .btn-save:hover { color: white; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(17,153,142,0.5); }
    .btn-back {
        background: #ecf0f1; color: #555; border: none;
        padding: 0.5rem 1.5rem; border-radius: 25px; font-weight: 600;
        transition: all 0.3s ease; text-decoration: none; display: inline-block;
    }
    .btn-back:hover { background: #d5d8dc; color: #333; text-decoration: none; }
    .card { border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-radius: 10px; }
    .image-preview {
        width: 100px; height: 100px; border-radius: 50%;
        object-fit: cover; border: 3px solid #11998e;
        display: none; margin-top: 10px;
    }
</style>
@endsection

@section('contents')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header-gradient">
                    <h3><i class="fas fa-user-shield mr-2"></i> Add New Admin</h3>
                </div>
                <div class="card-body p-4">
                    <form id="create_form" action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="alert alert-danger" id="error_alert" hidden>
                            <ul id="error_messages_ul" class="mb-0"></ul>
                        </div>

                        {{-- Basic Info --}}
                        <div class="section-title"><i class="fas fa-info-circle mr-1"></i> Basic Information</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country_id"><i class="fas fa-globe mr-1 text-muted"></i> Country</label>
                                    <select class="form-control @error('country_id') is-invalid @enderror" id="country_id" name="country_id">
                                        <option value="">-- Select Country --</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name"><i class="fas fa-user mr-1 text-muted"></i> Admin Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" placeholder="Enter Admin Name">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name"><i class="fas fa-user mr-1 text-muted"></i> Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Enter last_name of Admin">
                                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email"><i class="fas fa-envelope mr-1 text-muted"></i> Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" placeholder="test@admin.com" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password"><i class="fas fa-lock mr-1 text-muted"></i> Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="••••••••" required minlength="6">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile"><i class="fas fa-phone mr-1 text-muted"></i> Mobile</label>
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                        id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="Enter Mobile of Admin">
                                    @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date"><i class="fas fa-calendar mr-1 text-muted"></i> Date</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        id="date" name="date" value="{{ old('date') }}">
                                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="address"><i class="fas fa-map-marker-alt mr-1 text-muted"></i> Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address') }}" placeholder="Enter Address of Admin">
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender"><i class="fas fa-venus-mars mr-1 text-muted"></i> Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="Male"   {{ old('gender') == 'Male'   ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status"><i class="fas fa-toggle-on mr-1 text-muted"></i> Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="Active"   {{ old('status', 'Active') == 'Active'   ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password_confirmation"><i class="fas fa-check-circle mr-1 text-muted"></i> Confirm Password</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm password" required minlength="6">
                                    @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="section-title mt-2"><i class="fas fa-image mr-1"></i> Profile Image</div>
                        <div class="form-group">
                            <label for="image"><i class="fas fa-camera mr-1 text-muted"></i> Choose Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <img id="image_preview" class="image-preview" src="#" alt="Preview">
                        </div>

                        <hr class="mt-3">

                        <div class="d-flex" style="gap: 10px;">
                            <button type="button" class="btn-save" onclick="performStore()">
                                <i class="fas fa-save mr-1"></i> Store
                            </button>
                            <a href="{{ route('admins.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left mr-1"></i> Go To Index
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
function previewImage(input) {
    const preview = document.getElementById('image_preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

function performStore() {
    let formData = new FormData();
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    formData.append('name', document.getElementById('name').value);
    formData.append('last_name', document.getElementById('last_name').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('password', document.getElementById('password').value);
    formData.append('password_confirmation', document.getElementById('password_confirmation').value);
    formData.append('mobile', document.getElementById('mobile').value);
    formData.append('country_id', document.getElementById('country_id').value);
    formData.append('date', document.getElementById('date').value);
    formData.append('address', document.getElementById('address').value);
    formData.append('gender', document.getElementById('gender').value);
    formData.append('status', document.getElementById('status').value);

    if (document.getElementById('image').files.length > 0) {
        formData.append('image', document.getElementById('image').files[0]);
    }

    storeRoute('/cms/admin/admins', formData);
}
</script>
@endsection
