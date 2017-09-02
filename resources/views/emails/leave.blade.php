<p>
    理由
    <ul>
    @foreach($reasons as $reason)
    	<li>{{ $reason }}</li>
    @endforeach
    </ul>
</p>

<p>
    その他の理由:
    {{ $otherReasons }}
</p>