<form action="{{ route('main') }}" class="mb-5">
    <div class="input-group">
        <input type="text" name="search" value="{{ $searchQuery ?? '' }}" class="form-control form-control-lg" placeholder="Search products..." />
        <div class="input-group-append">
            <button class="btn btn-lg btn-primary" type="submit">Search</button>
        </div>
    </div>
</form>
