<div class="btn-group mx-2">
    <a data-toggle="dropdown" href="#">
        <i class="fa fa-search fa-2x text-white" aria-hidden="true"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <form class="form-inline my-0 dropdown-item" method="GET" action="{{ url('/timeline') }}">
            <input class="form-control mr-2" type="text" placeholder="検索" value="{{ $searchWords or '' }}" name="searchWords" required>
            <button class="yy-pointer btn btn-outline-success" type="submit">検索</button>
        </form>
    </div>
</div>
