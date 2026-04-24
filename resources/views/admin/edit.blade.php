@extends('cms.perant')

@section('title', 'Edit Admin')
@section('mine-title', 'Admins Management')
@section('sub-title', 'Edit Admin Details')

@section('styles')
<style>
    .card-header-gradient {
        background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
        color: #2c3e50;
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
        border-color: #f7971e;
        box-shadow: 0 0 0 0.2rem rgba(247,151,30,0.15);
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
    .current-image {
        width: 100px; height: 100px; border-radius: 50%;
        object-fit: cover; border: 3px solid #f7971e; display: block; margin-bottom: 8px;
    }
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
                    <h3><i class="fas fa-edit mr-2"></i> Edit Admin</h3>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Basic Info --}}
                        <div class="section-title"><i class="fas fa-info-circle mr-1"></i> Basic Information</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country_id"><i class="fas fa-globe mr-1 text-muted"></i> Country</label>
                                    <select class="form-control @error('country_id') is-invalid @enderror" id="country_id" name="country_id">
                                        <option value="">-- Select Country --</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('country_id', $admin->country_id) == $country->id ? 'selected' : '' }}>
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
                                        id="name" name="name" value="{{ old('name', $admin->name) }}" placeholder="Enter Admin Name">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name"><i class="fas fa-user mr-1 text-muted"></i> Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name" value="{{ old('last_name', $admin->last_name) }}" placeholder="Enter last_name of Admin">
                                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email"><i class="fas fa-envelope mr-1 text-muted"></i> Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password"><i class="fas fa-lock mr-1 text-muted"></i> New Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="اتركه فارغاً إذا لم ترد التغيير">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile"><i class="fas fa-phone mr-1 text-muted"></i> Mobile</label>
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                        id="mobile" name="mobile" value="{{ old('mobile', $admin->mobile) }}" placeholder="Enter Mobile of Admin">
                                    @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date"><i class="fas fa-calendar mr-1 text-muted"></i> Date</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        id="date" name="date" value="{{ old('date', $admin->date ? $admin->date->format('Y-m-d') : '') }}">
                                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="address"><i class="fas fa-map-marker-alt mr-1 text-muted"></i> Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address', $admin->address) }}" placeholder="Enter Address of Admin">
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender"><i class="fas fa-venus-mars mr-1 text-muted"></i> Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="Male"   {{ old('gender', $admin->gender) == 'Male'   ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $admin->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status"><i class="fas fa-toggle-on mr-1 text-muted"></i> Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="Active"   {{ old('status', $admin->status) == 'Active'   ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status', $admin->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password_confirmation"><i class="fas fa-check-circle mr-1 text-muted"></i> Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="section-title mt-2"><i class="fas fa-image mr-1"></i> Profile Image</div>
                        <div class="form-group">
                            @if($admin->image)
                                <img src="{{ asset($admin->image) }}" class="current-image" alt="Current Image">
                            @endif
                            <label for="image"><i class="fas fa-camera mr-1 text-muted"></i> Choose New Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <img id="image_preview" class="image-preview" src="#" alt="Preview">
                        </div>

                        <hr class="mt-3">

                        <div class="d-flex" style="gap: 10px;">
                            <button type="button" class="btn-update" onclick="performUpdate({{ $admin->id }})">
                                <i class="fas fa-save mr-1"></i> Update
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

function performUpdate(id) {
    let data = {
        _token: document.querySelector('input[name=\"_token\"]').value,
        name: document.getElementById('name').value,
        last_name: document.getElementById('last_name').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        mobile: document.getElementById('mobile').value,
        country_id: document.getElementById('country_id').value,
        date: document.getElementById('date').value,
        address: document.getElementById('address').value,
        gender: document.getElementById('gender').value,
        status: document.getElementById('status').value,
    };

    updateRoute('/cms/admin/admins-update/' + id, data);
}
</script>
@endsection
