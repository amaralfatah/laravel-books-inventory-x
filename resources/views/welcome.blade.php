@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-4 d-flex justify-content-start align-items-center">
        <h3>Dashboard</h3>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        {{-- Total Books --}}
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card  border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Books</p>
                    <h3 class="mb-2">{{ number_format($totalBooks) }}</h3>
                </div>
            </div>
        </div>

        {{-- Total Categories --}}
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card  border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted mb-1">Categories</p>
                    <h3 class="mb-2">{{ number_format($totalCategories) }}</h3>
                </div>
            </div>
        </div>


        {{-- Popular Category --}}
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card  border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted mb-1">Popular Category</p>
                    <h3 class="mb-2">{{ $popularCategory->name }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Books by Category & Recent Books --}}
    <div class="row g-3">
        {{-- Books by Category --}}
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Books by Category</h5>
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                            <tr>
                                <th class="border-0 ps-4">Category</th>
                                <th class="border-0 text-end pe-4">Books</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($booksByCategory as $category)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-medium">{{ $category->name }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        {{ number_format($category->books_count) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Books --}}
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Books</h5>
                    <a href="{{ route('books.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                            <tr>
                                <th class="border-0 ps-4">Book Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recentBooks as $book)
                                <tr>
                                    <td class="ps-4">
                                        <div>
                                            <span class="fw-medium">{{ $book->title }}</span>
                                            <div class="small text-muted">
                                                {{ $book->author }} · {{ $book->category->name }}
                                            </div>
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
