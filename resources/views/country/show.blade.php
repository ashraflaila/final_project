@extends('cms.perant')

@section('title' , 'Show-Country')

@section('mine-title' , 'Show-Country')

@section('sub-title' , 'show-country')

@section('styles')

@endsection

@section('contents')

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Show Country</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('countries.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Country Name -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="country_name" class="form-label">Country Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="country_name"disabled
                            name="country_name"
                            value="{{ $countries->country_name }}"
                            required>
                    </div>
                </div>

                <!-- Country Code -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="country_code" class="form-label">Country Code</label>
                        <input
                            type="text"
                            class="form-control"
                            id="country_code"disabled
                            name="country_code"
                             value="{{ $countries->code }}"
                            required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-warning mt-3">
                Show
            </button>
                        <a href="{{ route('countries.index') }}" type="submit" class="btn btn-dark mt-3">
                GO BACK
                        </a>
        </form>
    </div>
</div>



@endsection


@section('scripts')

@endsection


