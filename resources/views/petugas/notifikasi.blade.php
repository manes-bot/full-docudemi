@extends('layouts.app')

@section('title', 'Notifikasi - DocuDemi')
@section('page-title', 'Notifikasi')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 20px; font-weight: 700;">Notifikasi Aktivitas</h2>
    </div>

    @forelse($notifikasis as $item)
        <div class="card" style="margin-bottom: 12px; padding: 16px;">
            <div style="display: flex; gap: 14px; align-items: center;">
                <i data-lucide="bell" style="color: #15803D;"></i>
                <div>
                    <div style="font-weight: 700; font-size: 14px;">
                        Pengajuan #DOC-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }} oleh {{ $item->alumni->nama ?? 'Alumni' }}
                    </div>
                    <div style="font-size: 12px; color: var(--text-muted);">
                        Status: <strong>{{ $item->status }}</strong> · {{ $item->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card" style="text-align: center; color: var(--text-muted); padding: 40px;">
            Belum ada notifikasi aktivitas terbaru.
        </div>
    @endforelse
</div>
<script src="{{ asset('js/docudemi-ui.js') }}"></script>
@endsection