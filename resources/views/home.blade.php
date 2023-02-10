@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Subir archivos') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.files.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input class="form-control mb-3" type="file" name="files[]" multiple required>
                        <div class="d-flex gap-3">
                            @foreach ($allowedCategories as $category)
                            <div class="d-flex gap-1">
                                <input type="radio" name="category" id="{{ $category->category }}" {{ count($allowedCategories) == 1 ? "checked" : "" }}>
                                <label for="{{ $category->category }}" class="text-capitalize fw-bold fs-5">{{ $category->category }}</label>    
                            </div>
                            @endforeach
                        </div>
                        <button type="submit" class="mt-4 btn btn-primary float-right">
                            Subir
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
