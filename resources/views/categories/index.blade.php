@extends('layouts.app')

@section('title', 'Category Management')

@section('content')

    {{-- Search Form & Header --}}
    <div class="mb-4">
        <div class="mb-3">
            <h3>Category List</h3>
        </div>

        <div class="row g-3">
            <div class="col-12 col-lg-10">
                <form action="{{ route('categories.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-12 col-sm-9">
                            <div class="input-group">
                           <span class="input-group-text border-end-0">
                               <i class="bi bi-search text-muted"></i>
                           </span>
                                <input type="text"
                                       name="search"
                                       class="form-control border-start-0"
                                       placeholder="Cari kategori..."
                                       value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="col-12 col-sm-3">
                            <button class="btn btn-primary w-100" type="submit">
                                <i class="bi bi-funnel me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12 col-lg-2">
                <button type="button"
                        class="btn btn-primary w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#addCategoryModal">
                    <i class="bi bi-plus me-2"></i> Add
                </button>
            </div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th class="px-4">
                            <a href="{{ route('categories.index', ['orderBy' => 'name', 'orderDirection' => request('orderDirection') === 'asc' ? 'desc' : 'asc'] + request()->except(['orderBy', 'orderDirection'])) }}">
                                Name
                            </a>
                        </th>
                        <th class="px-4 text-end" style="width: 140px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($datas as $category)
                        <tr>
                            <td class="px-4">{{ $category->name }}</td>
                            <td class="px-4 text-end">
                                <div class="btn-group">
                                    <button class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal{{ $category->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox h4 d-block"></i>
                                Tidak ada data kategori
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-4 py-3 border-top">
                {{ $datas->links() }}
            </div>
        </div>
    </div>


    {{-- ========== Modals Section ========== --}}
    {{-- Add Category Modal --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" name="name" required
                                   placeholder="Masukkan nama kategori">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit & Delete Category Modals --}}
    @foreach ($datas as $category)
        {{-- Edit Modal --}}
        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ $category->name }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Hapus Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="bi bi-exclamation-triangle text-warning display-3"></i>
                        <h5 class="mt-3">Apakah Anda yakin?</h5>
                        <p class="text-muted mb-0">
                            Kategori "{{ $category->name }}" akan dihapus secara permanen.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
