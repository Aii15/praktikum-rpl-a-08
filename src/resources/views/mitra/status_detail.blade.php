@extends('mitra.layout')

@section('styles')
    <style>
        .detail-card {
            max-width: 700px;
            background: #f9fafb;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .detail-banner {
            width: 100%;
            height: 280px;
            object-fit: cover;
            display: block;
        }

        .detail-info {
            padding: 26px;
        }

        .detail-info h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-group {
            margin: 0;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 12px;
        }

        .info-group.full {
            grid-column: 1 / -1;
        }

        .info-group strong {
            display: block;
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-group p {
            font-size: 15px;
            font-weight: 500;
            color: #1f2937;
            margin: 0;
            line-height: 1.5;
        }

        .status-badge {
            display: inline-block;
            margin-top: 22px;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .approved {
            background: #dcfce7;
            color: #15803d;
        }

        .pending {
            background: #fef3c7;
            color: #b45309;
        }

        .rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .back-btn:hover {
            color: #111827;
            transform: translateX(-4px);
        }

        /* Custom Confirmation Modal Styles */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .custom-modal-overlay.active {
            opacity: 1;
        }

        .custom-modal-box {
            background: #ffffff;
            border-radius: 16px;
            width: 90%;
            max-width: 400px;
            padding: 28px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            text-align: center;
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .custom-modal-overlay.active .custom-modal-box {
            transform: scale(1);
        }

        .custom-modal-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            margin: 0 auto 18px;
        }

        .custom-modal-icon.success {
            background: #dcfce7;
            color: #15803d;
        }

        .custom-modal-icon.danger {
            background: #fee2e2;
            color: #ef4444;
        }

        .custom-modal-box h3 {
            font-size: 19px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .custom-modal-box p {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .custom-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .custom-modal-btn {
            flex: 1;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }
    </style>
@endsection

@section('content')
    <h1>Detail Status Pengajuan</h1>

    <div class="detail-card">
        <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="detail-banner" alt="{{ $property->nama_properti }}" style="object-position: {{ $property->coverPhoto->position_style ?? 'center 50%' }};">

        <div class="detail-info">
            <h2>{{ $property->nama_properti }}</h2>

            <div class="info-grid">
                <div class="info-grid">
                    <div class="info-group">
                        <strong>Kategori</strong>
                        <p>{{ $property->category->nama_kategori ?? 'Kategori tidak tersedia' }}</p>
                    </div>

                    <div class="info-group">
                        <strong>Lokasi</strong>
                        <p>{{ $property->location->kota ?? 'Lokasi tidak diketahui' }}</p>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-group">
                        <strong>Alamat Lengkap</strong>
                        <p>{{ $property->location->alamat_detail ?? '-' }}</p>
                    </div>

                    <div class="info-group">
                        <strong>Harga Per Hari</strong>
                        <p>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="info-group full">
                    <strong>Fasilitas</strong>
                    <p>{{ $property->fasilitas ?? 'Tidak ada fasilitas terdaftar' }}</p>
                </div>

                <div class="info-group full">
                    <strong>Deskripsi</strong>
                    <p>{{ $property->deskripsi }}</p>
                </div>
            </div>

            @if($property->status_pengajuan === 'approved')
                <div class="status-badge approved">Disetujui</div>
            @elseif($property->status_pengajuan === 'pending')
                <div style="display: flex; align-items: center; gap: 15px; margin-top: 22px;">
                    <div class="status-badge pending" style="margin-top: 0;">Menunggu</div>
                    <form id="cancelPropertyForm" action="{{ route('mitra.property.delete', $property->id_properti) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="button" onclick="confirmCancelProperty()" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 8px 18px; border-radius: 30px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; font-family: 'Poppins', sans-serif; outline: none;">
                            Batalkan Pengajuan
                        </button>
                    </form>
                </div>
            @else
                <div class="status-badge rejected">{{ ucfirst($property->status_pengajuan) }}</div>
            @endif
        </div>
    </div>

    <a href="{{ route('mitra.status') }}" class="back-btn">
        ← Kembali ke Status Pengajuan
    </a>
@endsection

@section('scripts')
    <script>
        function showCustomConfirm(message, actionType = 'confirm') {
            return new Promise((resolve) => {
                const overlay = document.createElement('div');
                overlay.className = 'custom-modal-overlay';
                
                let confirmBtnStyle = 'background: #f7c948; color: #111111;';
                if (actionType === 'danger') {
                    confirmBtnStyle = 'background: #e11d48; color: #ffffff;';
                }
                
                overlay.innerHTML = `
                    <div class="custom-modal-box">
                        <div class="custom-modal-icon ${actionType === 'danger' ? 'danger' : 'success'}">
                            ${actionType === 'danger' ? '!' : '?'}
                        </div>
                        <h3>Konfirmasi</h3>
                        <p>${message}</p>
                        <div class="custom-modal-actions" style="display: flex; gap: 12px; justify-content: center;">
                            <button class="custom-modal-btn cancel-btn" style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db;">Batal</button>
                            <button class="custom-modal-btn confirm-btn" style="${confirmBtnStyle}">Ya, Lanjutkan</button>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(overlay);
                
                setTimeout(() => {
                    overlay.classList.add('active');
                }, 10);
                
                const cancelBtn = overlay.querySelector('.cancel-btn');
                const confirmBtn = overlay.querySelector('.confirm-btn');
                
                function close() {
                    overlay.classList.remove('active');
                    setTimeout(() => {
                        overlay.remove();
                    }, 300);
                }
                
                cancelBtn.onclick = () => {
                    close();
                    resolve(false);
                };
                
                confirmBtn.onclick = () => {
                    close();
                    resolve(true);
                };
                
                overlay.onclick = (e) => {
                    if (e.target === overlay) {
                        close();
                        resolve(false);
                    }
                };
            });
        }

        async function confirmCancelProperty() {
            const confirmed = await showCustomConfirm('Apakah Anda yakin ingin membatalkan pengajuan properti ini?', 'danger');
            if (confirmed) {
                document.getElementById('cancelPropertyForm').submit();
            }
        }
    </script>
@endsection
