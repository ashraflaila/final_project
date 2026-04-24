@extends('cms.parent')

@section('title', 'الدروس')
@section('main-title', 'الدروس')
@section('sub-title', 'عرض الدروس')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">قائمة الدروس</h3>
                        <div class="card-tools">
                            <a href="{{ route('lessons.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> إضافة درس جديد
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>العنوان</th>
                                    <th>المحتوى</th>
                                    <th>المساق</th>
                                    <th style="width: 150px">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lessons as $lesson)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $lesson->title }}</td>
                                        <td>{{ Str::limit($lesson->content, 50) ?? 'لا يوجد محتوى' }}</td>
                                        <td>{{ $lesson->course->name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i> تعديل
                                                </a>
                                                <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
                                                        <i class="fas fa-trash"></i> حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection