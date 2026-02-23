@extends('cms.perant')

@section('title' , 'Country')

@section('mine-title' , 'Index_country')

@section('sub-title' , 'Index_country')

@section('styles')

@endsection

@section('contents')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h3 class="card-title">Simple Full Width Table</h3> --}}
                        <a href="{{ route('countries.create') }}" type="submit" class="btn btn-warning mt-3">
               ADD NEW COUNTRY
                        </a>

                    <div class="card-tools">
                        <ul class="pagination pagination-sm float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped"> {{-- أضفت table-striped ليكون أجمل --}}
                        <thead>




                            <tr>
                                <th style="width: 10px">id</th>
                                <th class="text-center">country_name</th>
                                <th class="text-center">cod</th>
                                <th class="text-center">>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($countries as $country)
                            <tr>



                                <td>{{ $country->id }}</td>
                                <td>{{ $country->country_name }}</td>
                                <td>{{ $country->code }}</td>
                                <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ route('countries.show', $country->id) }}" class="btn btn-outline-info btn-sm" title="عرض التفاصيل">
            <i class="fas fa-eye"></i>
        </a>

        <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-outline-warning btn-sm" title="تعديل">
            <i class="fas fa-edit"></i>
        </a>

        <form action="{{ route('countries.destroy', $country->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm" title="حذف">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
</td>

                           @endforeach
                        </tbody>
                    </table>
                </div>
              {{ $countries -> links() }}
        </div>
                </div>
            </div>
    </div>
</div>

@endsection


@section('scripts')

@endsection


