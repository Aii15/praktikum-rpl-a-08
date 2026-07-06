{{-- partial: menampilkan pesan flash (success/error/info) --}}
@if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:10px;border-radius:8px;margin-bottom:12px;">
        {{ session('success') }}
    </div>
@endif

@if(session('info'))
    <div style="background:#eff6ff;color:#1e3a8a;padding:10px;border-radius:8px;margin-bottom:12px;">
        {{ session('info') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#fee2e2;color:#991b1b;padding:10px;border-radius:8px;margin-bottom:12px;">
        <ul style="margin:0;padding-left:18px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif
