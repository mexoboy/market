@php
/** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
/** @var \OpenFoodFacts\Document $item */
/** @var bool[] $existProductsIDs */
@endphp
@extends('layout.main')
@section('scripts')
    <script src="/static/js/search.js?v={{ substr(md5_file(public_path('static/js/search.js')), 0, 6) }}" type="application/javascript"></script>
@endsection
@section('content')
    @include('partials.search-form')
    {{ $paginator->links() }}
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Product name</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($paginator->items() as $item)
            <tr>
                <td>{{ $item->_id }}</td>
                <td>{{ $item->product_name }}</td>
                <td>
                    @if(isset($item->image_url))
                        <a href="{{ $item->image_url }}" target="_blank"><img src="{{ $item->image_url }}" height="100" alt="" /></a>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-primary js-product-action"
                            data-action="{{ route('document.store', ['id' => $item->_id], false) }}">
                        {{ $existProductsIDs[$item->_id] ? 'Update' : 'Save' }}
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
    {{ $paginator->links() }}
@endsection
