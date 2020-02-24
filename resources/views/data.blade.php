<nav aria-label="Page navigation example">
    <ul class="pagination">
        @if($page > 1)
            <li class="page-item"><a class="page-link" href="/data?page={{ $prevPage }}">Previous</a></li>
        @endif

        @if($page < $maxPage)
            <li class="page-item"><a class="page-link" href="/data?page={{ $nextPage }}">Next</a></li>
        @endif
    </ul>
</nav>
<hr>
<table class="table">
    <thead>
    <tr>
        <th style="border: 1px solid red" scope="col">#</th>
        @foreach ($properties as $property)
            <th style="border: 1px solid red" scope="col">{{ $property }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data as $key => $item)
        <tr>
            <th style="border: 1px solid red" scope="row">{{ $key }}</th>
            @foreach ($properties as $property)
                <td style="border: 1px solid black">
                    @if($property === 'match_id')
                        <a href="/data?match_id= {{ $item->$property }}">{{ $item->$property }}</a>
                    @else
                        {{ $item->$property }}
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
<hr>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        @if($page > 1)
            <li class="page-item"><a class="page-link" href="/data?page={{ $prevPage }}">Previous</a></li>
        @endif

        @if($page < $maxPage)
            <li class="page-item"><a class="page-link" href="/data?page={{ $nextPage }}">Next</a></li>
        @endif
    </ul>
</nav>
