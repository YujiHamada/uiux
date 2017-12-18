<p>退会ユーザー名：{{ Auth::user()->name }}</p>
<p>退会ユーザーID：{{ Auth::id() }}</p>
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