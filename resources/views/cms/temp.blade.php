@extends('cms.perant')

@section('title' , 'Dashboard')

@section('mine-title' , 'Dashboard')

@section('sub-title' , 'Statistics')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
    }
    .stat-card {
        border: 0;
        border-radius: 18px;
        padding: 22px;
        color: white;
        box-shadow: 0 12px 30px rgba(31, 41, 55, 0.12);
    }
    .stat-card h3 {
        margin: 0 0 8px;
        font-size: 1rem;
        font-weight: 700;
    }
    .stat-card .stat-number {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }
    .stat-card .stat-link {
        display: inline-block;
        margin-top: 12px;
        color: rgba(255,255,255,0.9);
        font-weight: 600;
    }
    .stat-a { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); }
    .stat-b { background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); }
    .stat-c { background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); }
    .stat-d { background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); }
    .stat-e { background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%); }
    .stat-f { background: linear-gradient(135deg, #db2777 0%, #be185d 100%); }
    .stat-g { background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); }
    .stat-h { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
    .stat-i { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
</style>
@endsection

@section('contents')
<div class="container-fluid">
    <div class="stats-grid">
        <div class="stat-card stat-a">
            <h3>Admins</h3>
            <div class="stat-number">{{ $stats['admins_count'] }}</div>
            <a class="stat-link" href="{{ route('admins.index') }}">View admins</a>
        </div>
        <div class="stat-card stat-b">
            <h3>Teachers</h3>
            <div class="stat-number">{{ $stats['teachers_count'] }}</div>
            <a class="stat-link" href="{{ route('teachers.index') }}">View teachers</a>
        </div>
        <div class="stat-card stat-c">
            <h3>Students</h3>
            <div class="stat-number">{{ $stats['students_count'] }}</div>
            <a class="stat-link" href="{{ route('students.index') }}">View students</a>
        </div>
        <div class="stat-card stat-d">
            <h3>Countries</h3>
            <div class="stat-number">{{ $stats['countries_count'] }}</div>
            <a class="stat-link" href="{{ route('countries.index') }}">View countries</a>
        </div>
        <div class="stat-card stat-e">
            <h3>Cities</h3>
            <div class="stat-number">{{ $stats['cities_count'] }}</div>
            <a class="stat-link" href="{{ route('cities.index') }}">View cities</a>
        </div>
        <div class="stat-card stat-f">
            <h3>Categories</h3>
            <div class="stat-number">{{ $stats['categories_count'] }}</div>
            <a class="stat-link" href="{{ route('categories.index') }}">View categories</a>
        </div>
        <div class="stat-card stat-g">
            <h3>Courses</h3>
            <div class="stat-number">{{ $stats['courses_count'] }}</div>
            <a class="stat-link" href="{{ route('courses.index') }}">View courses</a>
        </div>
        <div class="stat-card stat-h">
            <h3>Lessons</h3>
            <div class="stat-number">{{ $stats['lessons_count'] }}</div>
            <a class="stat-link" href="{{ route('lessons.index') }}">View lessons</a>
        </div>
        <div class="stat-card stat-i">
            <h3>Trashed Records</h3>
            <div class="stat-number">{{ $stats['trashed_count'] }}</div>
            <span class="stat-link">Across all modules</span>
        </div>
    </div>
</div>
@endsection


@section('scripts')

@endsection

