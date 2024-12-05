@extends('layouts.app')

@section('title', 'Manajemen Buku')

@section('content')

    {{-- Search Form & Header --}}
    <div class="mb-4">

        <div class="mb-3">
            <h3>Book List</h3>
        </div>

        <div class="row g-3">
            <div class="col-12 col-lg-10">

                <form action="{{ route('books.index') }}" method="GET">
                    <div class="row g-2">
                        <!-- Search Input -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                                <input type="text" name="search"
                                       class="form-control border-start-0"
                                       placeholder="Cari .."
                                       value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <select name="category_id" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <input type="date"
                                   name="publication_date"
                                   class="form-control"
                                   value="{{ request('publication_date') }}">
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <input type="hidden" name="orderBy" value="{{ request('orderBy', 'title') }}">
                            <input type="hidden" name="orderDirection" value="{{ request('orderDirection', 'asc') }}">
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
                        data-bs-target="#addBookModal">
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
                            <a href="{{ route('books.index', ['orderBy' => 'title', 'orderDirection' => request('orderDirection') === 'asc' ? 'desc' : 'asc'] + request()->except(['orderBy', 'orderDirection'])) }}">
                                Title
                            </a>
                        </th>
                        <th class="px-4">
                            <a href="{{ route('books.index', ['orderBy' => 'author', 'orderDirection' => request('orderDirection') === 'asc' ? 'desc' : 'asc'] + request()->except(['orderBy', 'orderDirection'])) }}">
                                Author
                            </a>
                        </th>
                        <th class="px-4">
                            <a href="{{ route('books.index', ['orderBy' => 'category_id', 'orderDirection' => request('orderDirection') === 'asc' ? 'desc' : 'asc'] + request()->except(['orderBy', 'orderDirection'])) }}">
                                Category
                            </a>
                        </th>
                        <th class="px-4">
                            <a href="{{ route('books.index', ['orderBy' => 'publication_date', 'orderDirection' => request('orderDirection') === 'asc' ? 'desc' : 'asc'] + request()->except(['orderBy', 'orderDirection'])) }}">
                                Publication Date
                            </a>
                        </th>
                        <th class="px-4 text-end">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td class="px-4">{{ $book->title }}</td>
                            <td class="px-4">{{ $book->author }}</td>
                            <td class="px-4">{{ $book->category->name }}</td>
                            <td class="px-4">{{ $book->publication_date }}</td>
                            <td class="px-4 text-end">
                                <div class="btn-group">
                                    <a href="{{route('books.download', $book)}}" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editBookModal{{ $book->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteBookModal{{ $book->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox h4 d-block"></i>
                                Tidak ada data buku
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-top">
                {{ $books->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>


    {{-- Modal Tambah Buku --}}
    <div class="modal fade" id="addBookModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" class="form-control" name="author" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Terbit</label>
                            <input type="date" class="form-control" name="publication_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Buku</label>
                            <input type="file" class="form-control" name="file_path">
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

    {{-- Modal Edit & Hapus --}}
    @foreach ($books as $book)
        {{-- Modal Edit --}}
        <div class="modal fade" id="editBookModal{{ $book->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Judul Buku</label>
                                <input type="text" class="form-control" name="title"
                                       value="{{ $book->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penulis</label>
                                <input type="text" class="form-control" name="author"
                                       value="{{ $book->author }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-control" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Terbit</label>
                                <input type="date" class="form-control" name="publication_date"
                                       value="{{ $book->publication_date }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">File Buku</label>
                                @if($book->file_path)
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <i class="bi bi-file-pdf text-danger"></i>
                                        <small class="text-muted">File saat
                                            ini: {{ basename($book->file_path) }}</small>
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="file_path">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Hapus --}}
        <div class="modal fade" id="deleteBookModal{{ $book->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Hapus Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="bi bi-exclamation-triangle text-warning display-3"></i>
                        <h5 class="mt-3">Apakah Anda yakin?</h5>
                        <p class="text-muted mb-0">
                            Buku "{{ $book->title }}" akan dihapus secara permanen.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('books.destroy', $book) }}" method="POST">
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
