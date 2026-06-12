@extends('mitra.layout')

@section('styles')
    <style>
        /* SPA Section Display and Fade Transitions */
        .content-section {
            display: none;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .content-section.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .form-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .field-card {
            min-height: 64px;
            background: #f3f4f6;
            border-radius: 10px;
            padding: 10px 18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid transparent;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .field-card:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .field-card:focus-within {
            background: #ffffff;
            border-color: #f7c948;
            box-shadow: 0 8px 20px rgba(247, 201, 72, 0.18);
            transform: translateY(-2px);
        }

        .field-text {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .field-text small {
            display: block;
            font-size: 10px;
            color: #666;
            margin-bottom: 2px;
        }

        .profile-input, .profile-select, .profile-textarea {
            border: none;
            background: transparent;
            font-size: 15px;
            font-weight: 500;
            color: #222;
            width: 100%;
            outline: none;
            padding: 0;
            margin-top: 2px;
            font-family: 'Poppins', sans-serif;
        }

        .profile-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .edit-icon {
            width: 20px;
            height: 20px;
            object-fit: contain;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .field-card:hover .edit-icon {
            opacity: 1;
            transform: scale(1.1);
        }

        .save-btn {
            background: #25943a;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px rgba(37, 148, 58, 0.3);
            display: inline-block;
            margin-top: 25px;
            float: right;
            outline: none;
        }

        .save-btn:hover {
            background: #1e7e30;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 22px rgba(37, 148, 58, 0.4);
        }

        .save-btn:active {
            transform: translateY(-1px) scale(0.98);
            box-shadow: 0 4px 12px rgba(37, 148, 58, 0.2);
        }

        /* Riwayat Penyewaan styles */
        .search-box {
            margin-bottom: 25px;
        }

        .search-box input {
            width: 100%;
            height: 50px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 12px;
            padding: 0 18px;
            font-size: 14px;
            outline: none;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            background: #fff;
            border-color: #f7c948;
            box-shadow: 0 4px 12px rgba(247, 201, 72, 0.15);
        }

        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .booking-card {
            background: #f9fafb;
            border-radius: 14px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
            text-decoration: none;
            color: #222;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid #e5e7eb;
        }

        .booking-card:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            border-color: #f7c948;
            background: #ffffff;
        }

        .booking-card:active {
            transform: translateY(-1px) scale(0.99);
        }

        .booking-card img {
            width: 130px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
        }

        .booking-info {
            flex: 1;
        }

        .booking-info h3 {
            font-size: 18px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .booking-info p {
            color: #666;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .booking-info strong {
            font-size: 15px;
            font-weight: 600;
            color: #d97706;
        }

        .status {
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }

        .success {
            background: #dcfce7;
            color: #15803d;
        }

        .completed {
            background: #e0f2fe;
            color: #0369a1;
        }

        .process {
            background: #fef3c7;
            color: #b45309;
        }

        .danger {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Properti Saya styles */
        .property-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .property-card {
            background: #f9fafb;
            border-radius: 14px;
            padding: 18px;
            display: grid;
            grid-template-columns: 130px 1fr 150px 100px;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid #e5e7eb;
        }

        .property-card:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            border-color: #f7c948;
            background: #ffffff;
        }

        .property-card img.property-thumb {
            width: 130px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
        }

        .property-info h3 {
            font-size: 18px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .property-info p {
            color: #666;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .property-info strong {
            font-size: 15px;
            font-weight: 600;
            color: #d97706;
        }

        .info-link {
            font-size: 14px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            text-align: right;
            transition: color 0.2s ease;
        }

        .info-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .delete-btn {
            border: none;
            background: transparent;
            color: #e11d48;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .delete-btn:hover {
            transform: scale(1.05);
            color: #be123c;
        }

        .delete-btn img {
            width: 18px;
            height: 18px;
            object-fit: contain;
        }

        /* Tambah Properti Form styles */
        .btn-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 25px;
        }

        .btn-next, .btn-submit, .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            border-radius: 12px;
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .btn-next {
            background: #f7c948;
            color: #111;
            box-shadow: 0 4px 14px rgba(247, 201, 72, 0.3);
        }

        .btn-next:hover {
            background: #e2b434;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 22px rgba(247, 201, 72, 0.4);
        }

        .btn-submit {
            background: #25943a;
            color: #fff;
            box-shadow: 0 4px 14px rgba(37, 148, 58, 0.3);
        }

        .btn-submit:hover {
            background: #1e7e30;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 22px rgba(37, 148, 58, 0.4);
        }

        .btn-back {
            background: #f3f4f6;
            color: #4b5563;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-right: auto;
        }

        .btn-back:hover {
            background: #e5e7eb;
            color: #1f2937;
            transform: translateY(-2px);
        }

        .btn-next:active, .btn-submit:active, .btn-back:active {
            transform: translateY(-1px) scale(0.98);
        }

        .dropzone-container {
            width: 100%;
            border: 2px dashed #cfd5db;
            border-radius: 12px;
            min-height: 250px;
            background: #f9fafb;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.25s ease;
            padding: 20px;
        }

        .dropzone-container:hover, .dropzone-container.dragover {
            border-color: #f7c948;
            background: #fff;
            box-shadow: 0 8px 20px rgba(247, 201, 72, 0.1);
        }

        .dropzone-container img.placeholder-icon {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin-bottom: 12px;
            opacity: 0.6;
            transition: opacity 0.2s ease;
        }

        .dropzone-container:hover img.placeholder-icon {
            opacity: 0.9;
        }

        .dropzone-container span.main-text {
            font-size: 16px;
            font-weight: 600;
            color: #4b5563;
        }

        .dropzone-container span.sub-text {
            font-size: 13px;
            color: #9ca3af;
            margin-top: 4px;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 12px;
            margin-top: 20px;
            width: 100%;
        }

        .preview-item {
            position: relative;
            aspect-ratio: 4/3;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-item .remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            cursor: pointer;
            font-weight: bold;
        }

        .dropdown-menu-list {
            display: none;
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            z-index: 100;
            max-height: 250px;
            overflow-y: auto;
            padding: 10px;
        }

        .dropdown-item-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            cursor: pointer;
            border-radius: 8px;
            transition: background 0.2s ease;
        }

        .dropdown-item-row:hover {
            background: #f3f4f6;
        }

        .dropdown-item-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #f7c948;
        }

        .dropdown-item-row img.facility-icon {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }

        .dropdown-item-row span {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .selected-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fef9c3;
            color: #a16207;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .selected-badge img {
            width: 14px;
            height: 14px;
            object-fit: contain;
        }

        /* Status Pengajuan styles */
        .status-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .status-card {
            background: #f9fafb;
            border-radius: 14px;
            padding: 18px;
            display: grid;
            grid-template-columns: 130px 1fr 120px;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
            text-decoration: none;
            color: #222;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid #e5e7eb;
        }

        .status-card:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            border-color: #f7c948;
            background: #ffffff;
        }

        .status-card:active {
            transform: translateY(-1px) scale(0.99);
        }

        .status-card img.property-thumb {
            width: 130px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
        }

        .status-info {
            flex: 1;
        }

        .status-info h3 {
            font-size: 18px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .status-info p {
            color: #666;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .status-info strong {
            font-size: 15px;
            font-weight: 600;
            color: #d97706;
        }

        .status-badge {
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
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

        /* Detail Penyewaan Styles */
        .detail-card {
            width: 100%;
            max-width: 650px;
            background: #f9fafb;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .06);
            margin-bottom: 12px;
        }

        .detail-banner {
            width: 100%;
            height: 180px;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .detail-info {
            padding: 22px;
        }

        .detail-info h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #111827;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 30px;
        }

        .info-group {
            margin: 0;
        }

        .info-group strong {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-group p {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin: 0;
            line-height: 1.5;
        }

        .booking-status {
            display: inline-block;
            margin-top: 15px;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .booking-status.success {
            background: #dcfce7;
            color: #15803d;
        }

        .booking-status.completed {
            background: #e0f2fe;
            color: #0369a1;
        }

        .booking-status.process {
            background: #fef3c7;
            color: #b45309;
        }

        .booking-status.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .back-btn {
            display: inline-block;
            margin-top: 8px;
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 10px;
            background: #f3f4f6;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .back-btn:hover {
            background: #e5e7eb;
            color: #111827;
            transform: translateX(-4px);
        }

        .back-btn:active {
            transform: translateX(0);
        }

        /* Loader inside section */
        .modal-loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
            gap: 12px;
        }

        .modal-spinner {
            width: 36px;
            height: 36px;
            border: 3px solid rgba(0, 0, 0, 0.08);
            border-top-color: #f7c948;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .modal-loader-container p {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Statistics Cards Styles */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            border-radius: 14px;
            padding: 22px 24px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
            border-left: 6px solid transparent;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .stat-card.blue {
            background: #f0f5ff;
            border-left-color: #2563eb;
        }

        .stat-card.green {
            background: #f0fdf4;
            border-left-color: #16a34a;
        }

        .stat-card.orange {
            background: #fffbeb;
            border-left-color: #d97706;
        }

        .stat-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card.blue .stat-title {
            color: #4b6b94;
        }

        .stat-card.green .stat-title {
            color: #4b8c62;
        }

        .stat-card.orange .stat-title {
            color: #8c6a38;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 700;
        }

        .stat-card.blue .stat-value {
            color: #1e40af;
        }

        .stat-card.green .stat-value {
            color: #15803d;
        }

        .stat-card.orange .stat-value {
            color: #78350f;
        }

        /* Filter Controls styles */
        .filter-controls-container {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 25px;
            position: relative;
            z-index: 20;
        }

        @media (max-width: 768px) {
            .filter-controls-container {
                grid-template-columns: 1fr;
            }
        }

        .filter-card {
            min-height: 64px;
            background: #f3f4f6;
            border-radius: 10px;
            padding: 10px 18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid transparent;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
        }

        .filter-card:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .filter-card:focus-within {
            background: #ffffff;
            border-color: #f7c948;
            box-shadow: 0 8px 20px rgba(247, 201, 72, 0.18);
            transform: translateY(-2px);
        }

        .selected-display {
            font-size: 15px;
            font-weight: 500;
            color: #222;
            margin-top: 2px;
        }

        .status-badge-inline {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge-inline.success {
            background: #dcfce7;
            color: #15803d;
        }

        .status-badge-inline.completed {
            background: #e0f2fe;
            color: #0369a1;
        }

        .status-badge-inline.process {
            background: #fef3c7;
            color: #b45309;
        }

        .status-badge-inline.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Detail Action Buttons */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }

        .approve-btn {
            background: #25943a;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 148, 58, 0.2);
        }

        .approve-btn:hover {
            background: #1e7e30;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 148, 58, 0.3);
        }

        .approve-btn:active {
            transform: translateY(-1px);
        }

        .reject-btn {
            background: #e11d48;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(225, 29, 72, 0.2);
        }

        .reject-btn:hover {
            background: #be123c;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(225, 29, 72, 0.3);
        }

        .reject-btn:active {
            transform: translateY(-1px);
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

        .custom-modal-icon.info {
            background: #fef9c3;
            color: #d97706;
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

        .custom-modal-btn.cancel-btn {
            background: #f3f4f6;
            color: #4b5563;
        }

        .custom-modal-btn.cancel-btn:hover {
            background: #e5e7eb;
        }

        .confirm-btn-success {
            background: #25943a;
            color: #ffffff;
        }

        .confirm-btn-success:hover {
            background: #1e7e30;
        }

        .confirm-btn-danger {
            background: #e11d48;
            color: #ffffff;
        }

        .confirm-btn-danger:hover {
            background: #be123c;
        }

        .custom-modal-btn.ok-btn {
            background: #f7c948;
            color: #111111;
            box-shadow: 0 4px 12px rgba(247, 201, 72, 0.2);
        }

        .custom-modal-btn.ok-btn:hover {
            background: #f5b91b;
            box-shadow: 0 6px 16px rgba(247, 201, 72, 0.3);
        }

        /* --- Sub-step 2A: Upload List Styles --- */
        .photo-upload-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 15px;
            width: 100%;
        }
        .upload-item-card {
            display: flex;
            flex-direction: column;
            background: #ffffff;
            border: 3px solid #e5e7eb;
            border-radius: 14px;
            padding: 12px;
            gap: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 0;
        }
        .upload-item-card:hover {
            border-color: #f7c948;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(247, 201, 72, 0.08);
        }
        .upload-item-thumb {
            width: 100%;
            aspect-ratio: 16/10;
            border-radius: 8px;
            overflow: hidden;
            border: 1.5px solid #e5e7eb;
            flex-shrink: 0;
            position: relative;
        }
        .upload-item-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
        }
        .upload-item-info {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 0;
        }
        .upload-item-title {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
            min-width: 0;
        }
        .upload-item-filename {
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            display: block;
            width: 100%;
            min-width: 0;
        }
        .upload-item-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            width: 100%;
            justify-content: flex-end;
            border-top: 1.5px solid #f3f4f6;
            padding-top: 10px;
            margin-top: auto;
        }

        /* --- Sub-step 2B: Sticky Wide Preview --- */
        .sticky-preview-wrapper {
            position: sticky;
            top: 0;
            z-index: 500;
            background: #ffffff;
            padding: 10px 0 20px 0;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 20px;
        }
        .preview-gallery-container {
            width: 100%;
            background: #f9fafb;
            border: 3px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            transition: all 0.25s ease;
        }
        .preview-gallery-container h3 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 14px;
            color: #111827;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 8px;
        }
        .btn-back-arrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f3f4f6;
            color: #4b5563;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-back-arrow:hover {
            background: #f7c948;
            color: #111111;
            border-color: #f7c948;
            transform: translateX(-2px);
            box-shadow: 0 4px 10px rgba(247, 201, 72, 0.2);
        }
        .mock-gallery {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr);
            gap: 10px;
            width: 100%;
            height: 180px; /* Reduced vertical height for compact wide proportions */
        }
        .mock-gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            background: #f3f4f6;
            border: 1.5px solid #e5e7eb;
            height: 100%;
            min-width: 0; /* Prevent grid items from expanding past tracks */
            min-height: 0;
        }
        .mock-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .mock-main-item {
            height: 100%;
        }
        .mock-side-gallery {
            display: grid;
            gap: 10px;
            height: 100%;
            min-width: 0; /* Prevent sub-grid track expansion */
            min-height: 0;
        }
        .mock-gallery-2 .mock-side-gallery {
            grid-template-columns: minmax(0, 1fr);
        }
        .mock-gallery-2 .mock-side-gallery .mock-gallery-item {
            height: 100%;
        }
        .mock-gallery-3 .mock-side-gallery {
            grid-template-rows: repeat(2, minmax(0, 1fr));
            grid-template-columns: minmax(0, 1fr);
        }
        .mock-gallery-3 .mock-side-gallery .mock-gallery-item {
            height: 100%;
        }
        .mock-gallery-4 .mock-side-gallery {
            grid-template-rows: repeat(2, minmax(0, 1fr));
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .mock-gallery-4 .mock-side-gallery .mock-gallery-item {
            height: 100%;
        }
        .mock-gallery-4 .mock-side-gallery .mock-gallery-item:first-child {
            grid-column: span 2;
        }
        .mock-gallery-5 .mock-side-gallery {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            grid-template-rows: repeat(2, minmax(0, 1fr));
        }
        .mock-gallery-5 .mock-side-gallery .mock-gallery-item {
            height: 100%;
        }
        .slot-label {
            position: absolute;
            bottom: 6px;
            left: 6px;
            background: rgba(0, 0, 0, 0.65);
            color: white;
            padding: 2px 6px;
            font-size: 10px;
            border-radius: 4px;
            font-weight: 500;
            pointer-events: none;
        }

        /* --- Interactive Crop Adjuster Cards --- */
        /* --- Sub-step 2B: Crop Table Styles --- */
        .crop-table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 15px;
        }
        .crop-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }
        .crop-table th {
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
            text-align: left;
            padding: 8px 16px;
            border-bottom: 2px solid #e5e7eb;
        }
        .crop-table td {
            background: #ffffff;
            border-top: 3px solid #e5e7eb;
            border-bottom: 3px solid #e5e7eb;
            padding: 12px 16px;
            vertical-align: middle;
        }
        .crop-table td:first-child {
            border-left: 3px solid #e5e7eb;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            width: 90px;
        }
        .crop-table td:last-child {
            border-right: 3px solid #e5e7eb;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }
        .crop-table tr:hover td {
            border-color: #f7c948;
            background: #fffdf5;
        }
        .crop-table tr:hover td:first-child {
            border-left-color: #f7c948;
        }
        .crop-table tr:hover td:last-child {
            border-right-color: #f7c948;
        }
        .crop-table-thumb {
            width: 60px;
            height: 40px;
            border-radius: 6px;
            overflow: hidden;
            border: 1.5px solid #e5e7eb;
            position: relative;
        }
        .crop-table-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center !important;
            display: block;
        }
        .crop-table-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
            max-width: 240px;
        }
        .crop-table-filename {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            display: block;
        }
        .badge-cover {
            background: #fef3c7;
            color: #d97706;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid #fcd34d;
            font-weight: 600;
            width: fit-content;
        }
        .badge-secondary {
            background: #f3f4f6;
            color: #4b5563;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
            font-weight: 600;
            width: fit-content;
        }
        .crop-table-adjuster {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }
        .crop-table-slider-cell {
            width: 220px;
        }
        .crop-slider {
            -webkit-appearance: none;
            appearance: none;
            flex: 1;
            height: 6px;
            border-radius: 3px;
            background: #e5e7eb;
            outline: none;
            transition: background 0.15s ease;
            cursor: pointer;
            min-width: 0;
        }
        .crop-slider:hover {
            background: #cbd5e1;
        }
        .crop-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #f7c948;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 6px rgba(247, 201, 72, 0.4);
            cursor: pointer;
            transition: transform 0.1s ease, background-color 0.1s ease;
        }
        .crop-slider::-webkit-slider-thumb:hover {
            transform: scale(1.2);
            background: #e2b434;
        }
        .crop-slider::-webkit-slider-thumb:active {
            transform: scale(0.95);
            background: #d97706;
        }
        .crop-slider::-moz-range-thumb {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #f7c948;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 6px rgba(247, 201, 72, 0.4);
            cursor: pointer;
            transition: transform 0.1s ease, background-color 0.1s ease;
        }
        .crop-slider::-moz-range-thumb:hover {
            transform: scale(1.2);
            background: #e2b434;
        }
        .crop-slider::-moz-range-thumb:active {
            transform: scale(0.95);
            background: #d97706;
        }
        .photo-control-actions {
            display: flex;
            flex-direction: column;
            gap: 6px;
            align-items: flex-end;
            flex-shrink: 0;
        }
        .btn-action {
            background: #f3f4f6;
            border: 1.5px solid #d1d5db;
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 11px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #374151;
            line-height: 1;
        }
        .btn-action:hover {
            background: #e5e7eb;
            border-color: #9ca3af;
            transform: scale(1.05);
        }
        .btn-delete {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #dc2626 !important;
        }
        .btn-delete:hover {
            background: #fecaca;
            border-color: #fca5a5;
        }

        /* --- Sidebar Collapse Transition --- */
        .profile-page {
            transition: grid-template-columns 0.5s cubic-bezier(0.4, 0, 0.2, 1), gap 0.5s cubic-bezier(0.4, 0, 0.2, 1), padding 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .sidebar {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), padding-right 0.5s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .content {
            transition: max-width 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .mock-gallery {
            transition: height 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .crop-table-slider-cell {
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        
        .profile-page.sidebar-collapsed {
            grid-template-columns: 0px 1fr !important;
            gap: 0px !important;
        }
        .profile-page.sidebar-collapsed .sidebar {
            transform: translateX(-380px) !important;
            opacity: 0 !important;
            pointer-events: none !important;
            padding-right: 0 !important;
            border-right-color: transparent !important;
        }
        .profile-page.sidebar-collapsed .content {
            max-width: 100% !important;
        }
        .profile-page.sidebar-collapsed .mock-gallery {
            height: 240px !important;
        }
        .profile-page.sidebar-collapsed .crop-table-slider-cell {
            width: 320px !important;
        }
        
    </style>
@endsection

@section('content')
    <!-- TOAST PERINGATAN PROFIL MITRA -->
    <div id="profile-toast-overlay" style="
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 99999;
        pointer-events: none;
    ">
        <div id="profile-toast-box" style="
            position: fixed;
            top: 28px;
            left: 50%;
            transform: translateX(-50%) translateY(-20px);
            background: #fff;
            border: 1.5px solid #ef4444;
            border-left: 5px solid #ef4444;
            border-radius: 12px;
            padding: 16px 24px;
            box-shadow: 0 8px 30px rgba(239,68,68,0.18);
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: #991b1b;
            min-width: 300px;
            max-width: 460px;
            pointer-events: all;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
        ">
            <span style="font-size: 20px; flex-shrink:0;">⚠️</span>
            <span id="profile-toast-msg">Mohon lengkapi semua data profil terlebih dahulu.</span>
            <button onclick="closeProfileToast()" style="margin-left:auto; background:none; border:none; cursor:pointer; font-size:18px; color:#9ca3af; line-height:1;" aria-label="Tutup">×</button>
        </div>
    </div>
    <!-- SECTION 1: TENTANG SAYA -->
    @include('mitra.partials.tentang-mitra')

    <!-- SECTION 2 & 6: RIWAYAT & DETAIL PENYEWAAN -->
    @include('mitra.partials.riwayat-penyewaan')

    <!-- SECTION 3: PROPERTI SAYA -->
    @include('mitra.partials.properti-saya')

    <!-- SECTION 4: TAMBAH PROPERTI -->
    @include('mitra.partials.tambah-properti')

    <!-- SECTION 5: STATUS PENGAJUAN -->
    @include('mitra.partials.status-pengajuan')
@endsection

@section('scripts')
    <script>
        // Global booking ID passed from server for direct loads
        window.activeBookingId = @json($activeBookingId ?? null);

        function navigateTo(path, pushState = true) {
            const menuTentangSaya = document.getElementById('menu-tentang-saya');
            const menuRiwayatPenyewaan = document.getElementById('menu-riwayat-penyewaan');
            const menuPropertiSaya = document.getElementById('menu-properti-saya');
            const menuTambahProperti = document.getElementById('menu-tambah-properti');
            const menuStatusPengajuan = document.getElementById('menu-status-pengajuan');

            const menuItems = [
                { path: '/profile-mitra', sectionId: 'section-tentang-saya', title: 'Profile Mitra - SpotRent', el: menuTentangSaya },
                { path: '/riwayat-penyewaan', sectionId: 'section-riwayat-penyewaan', title: 'Riwayat Penyewaan - SpotRent', el: menuRiwayatPenyewaan },
                { path: '/properti-saya', sectionId: 'section-properti-saya', title: 'Properti Saya - SpotRent', el: menuPropertiSaya },
                { path: '/tambah-properti', sectionId: 'section-tambah-properti', title: 'Tambah Properti - SpotRent', el: menuTambahProperti },
                { path: '/status-pengajuan', sectionId: 'section-status-pengajuan', title: 'Status Pengajuan - SpotRent', el: menuStatusPengajuan },
                { path: '/detail-riwayat-penyewaan', sectionId: 'section-detail-penyewaan', title: 'Detail Penyewaan - SpotRent', el: menuRiwayatPenyewaan }
            ];

            let isDetail = path.match(/^\/detail-riwayat-penyewaan\/(\d+)$/);
            let matchedPath = isDetail ? '/detail-riwayat-penyewaan' : path;

            // Find matching route
            let matched = menuItems.find(item => item.path === matchedPath);
            if (!matched) {
                // fallback to profile
                matched = menuItems[0];
            }

            // Show matched section, hide others
            menuItems.forEach(item => {
                const sec = document.getElementById(item.sectionId);
                if (sec) {
                    if (item === matched) {
                        sec.style.display = 'block';
                        sec.offsetHeight; // force reflow
                        sec.classList.add('active');
                        if (item.el) item.el.classList.add('active');
                    } else {
                        sec.classList.remove('active');
                        sec.style.display = 'none';
                        if (item.el && item.el !== matched.el) {
                            item.el.classList.remove('active');
                        }
                    }
                }
            });

            document.title = matched.title;

            if (pushState) {
                history.pushState({ path: path }, '', path);
            }

            if (isDetail) {
                const id = isDetail[1];
                showRentalDetail(null, id, false);
            }

            // Restore sidebar whenever page changes in router
            const profilePage = document.querySelector('.profile-page');
            if (profilePage) {
                profilePage.classList.remove('sidebar-collapsed');
            }
            const btnBackCropTop = document.getElementById('btn-back-crop-top');
            if (btnBackCropTop) {
                btnBackCropTop.style.display = 'none';
            }
        }
        window.navigateTo = navigateTo;

        function showRentalDetail(event, id, shouldPushState = true) {
            if (event) event.preventDefault();
            
            const loader = document.getElementById('detailLoading');
            const body = document.getElementById('detailBody');
            
            if (loader) loader.style.display = 'flex';
            if (body) body.style.display = 'none';

            if (shouldPushState) {
                navigateTo(`/detail-riwayat-penyewaan/${id}`);
                return;
            }
            
            fetch(`/detail-riwayat-penyewaan/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && body && loader) {
                    const booking = data.booking;
                    
                    document.getElementById('detailBanner').src = booking.cover_photo;
                    document.getElementById('detailBanner').style.objectPosition = `center ${booking.cover_photo_position || '50'}%`;
                    document.getElementById('detailPropertyName').textContent = booking.nama_properti;
                    
                    document.getElementById('detailPenyewa').textContent = booking.penyewa;
                    document.getElementById('detailEmailPenyewa').textContent = booking.email_penyewa;
                    document.getElementById('detailNoHpPenyewa').textContent = booking.no_hp_penyewa;
                    document.getElementById('detailRentangSewa').textContent = booking.rentang_sewa;
                    document.getElementById('detailTotalPrice').textContent = booking.total_price_formatted;

                    const statusBadge = document.getElementById('detailStatusBadge');
                    statusBadge.textContent = booking.status_text;
                    if (booking.status_booking === 'pending') {
                        statusBadge.className = 'booking-status process';
                    } else if (booking.status_booking === 'confirmed') {
                        statusBadge.className = 'booking-status success';
                    } else if (booking.status_booking === 'completed') {
                        statusBadge.className = 'booking-status completed';
                    } else {
                        statusBadge.className = 'booking-status danger';
                    }
                    
                    window.currentViewingBookingId = booking.id_booking;
                    const actionButtons = document.getElementById('bookingActionButtons');
                    if (actionButtons) {
                        if (booking.status_booking === 'pending') {
                            actionButtons.style.display = 'flex';
                        } else {
                            actionButtons.style.display = 'none';
                        }
                    }
                    
                    // Handle Review & Feedback Section
                    const reviewSection = document.getElementById('detailReviewSection');
                    const tenantReviewContainer = document.getElementById('tenantReviewContainer');
                    const feedbackForm = document.getElementById('feedbackForm');
                    const existingFeedback = document.getElementById('existingFeedback');
                    
                    if (booking.review) {
                        reviewSection.style.display = 'block';
                        tenantReviewContainer.style.display = 'block';
                        
                        // Render stars
                        let starsHtml = '';
                        for (let i = 1; i <= 5; i++) {
                            if (i <= booking.review.rating) {
                                starsHtml += '★';
                            } else {
                                starsHtml += '☆';
                            }
                        }
                        document.getElementById('displayReviewStars').textContent = starsHtml;
                        document.getElementById('displayReviewDate').textContent = booking.review.tanggal_review;
                        document.getElementById('displayReviewText').textContent = booking.review.komentar || 'Tidak ada komentar tertulis.';
                        
                        window.currentReviewId = booking.review.id_review;
                        
                        if (booking.review.balasan_mitra) {
                            feedbackForm.style.display = 'none';
                            existingFeedback.style.display = 'block';
                            
                            document.getElementById('displayFeedbackAuthor').textContent = 'Anda (Pemilik Properti)';
                            document.getElementById('displayFeedbackDate').textContent = booking.review.tanggal_balasan;
                            document.getElementById('displayFeedbackText').textContent = booking.review.balasan_mitra;
                        } else {
                            feedbackForm.style.display = 'block';
                            existingFeedback.style.display = 'none';
                            document.getElementById('feedbackText').value = '';
                        }
                    } else {
                        reviewSection.style.display = 'none';
                        tenantReviewContainer.style.display = 'none';
                        window.currentReviewId = null;
                    }
                    
                    loader.style.display = 'none';
                    body.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching rental details:', error);
                if (loader) {
                    loader.innerHTML = '<p style="color: #dc3545; font-size: 14px; font-weight: 500;">Gagal memuat detail penyewaan. Silakan coba lagi.</p>';
                }
            });
        }
        window.showRentalDetail = showRentalDetail;

        function submitFeedback(event) {
            event.preventDefault();
            const text = document.getElementById('feedbackText').value;

            if (!text.trim()) {
                showCustomAlert('Silakan tulis tanggapan terlebih dahulu.', 'danger');
                return;
            }

            const reviewId = window.currentReviewId;
            if (!reviewId) {
                showCustomAlert('ID ulasan tidak ditemukan.', 'danger');
                return;
            }

            fetch(`/mitra/review/${reviewId}/feedback`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    balasan_mitra: text
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCustomAlert(data.message, 'success').then(() => {
                        showRentalDetail(null, window.currentViewingBookingId, false);
                    });
                } else {
                    showCustomAlert(data.message || 'Gagal mengirim tanggapan.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error submitting feedback:', error);
                showCustomAlert('Terjadi kesalahan saat mengirim tanggapan.', 'danger');
            });
        }
        window.submitFeedback = submitFeedback;



        async function updateBookingStatus(status) {
            const bookingId = window.currentViewingBookingId;
            if (!bookingId) return;

            const confirmMsg = status === 'confirmed' 
                ? 'Apakah Anda yakin ingin menyetujui penyewaan ini?' 
                : 'Apakah Anda yakin ingin menolak penyewaan ini?';

            const actionType = status === 'confirmed' ? 'success' : 'danger';
            const confirmed = await showCustomConfirm(confirmMsg, actionType);
            if (!confirmed) return;

            const actionButtons = document.getElementById('bookingActionButtons');
            const statusBadge = document.getElementById('detailStatusBadge');
            
            if (actionButtons) actionButtons.style.opacity = '0.5';

            fetch(`/detail-riwayat-penyewaan/${bookingId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(async data => {
                if (actionButtons) actionButtons.style.opacity = '1';
                
                if (data.success) {
                    if (actionButtons) actionButtons.style.display = 'none';
                    
                    if (statusBadge) {
                        statusBadge.textContent = data.booking.status_text;
                        if (status === 'confirmed') {
                            statusBadge.className = 'booking-status success';
                        } else {
                            statusBadge.className = 'booking-status danger';
                        }
                    }
                    
                    const card = document.querySelector(`.booking-card[href*="/detail-riwayat-penyewaan/${bookingId}"]`);
                    if (card) {
                        card.setAttribute('data-status', status);
                        const cardStatusDiv = card.querySelector('.status');
                        if (cardStatusDiv) {
                            if (status === 'confirmed') {
                                cardStatusDiv.className = 'status success';
                                cardStatusDiv.textContent = 'Disetujui';
                            } else {
                                cardStatusDiv.className = 'status danger';
                                cardStatusDiv.textContent = 'Ditolak';
                            }
                        }
                    }

                    // Update sidebar notification bubble dynamically
                    const bubble = document.querySelector('#menu-riwayat-penyewaan .notification-bubble');
                    if (bubble) {
                        let count = parseInt(bubble.textContent.trim()) || 0;
                        count = Math.max(0, count - 1);
                        if (count > 0) {
                            bubble.textContent = count;
                        } else {
                            bubble.remove();
                        }
                    }
                    
                    await showCustomAlert(data.message, 'success');
                } else {
                    await showCustomAlert(data.message || 'Gagal memperbarui status.', 'info');
                }
            })
            .catch(async error => {
                if (actionButtons) actionButtons.style.opacity = '1';
                console.error('Error updating booking status:', error);
                await showCustomAlert('Terjadi kesalahan saat memproses permintaan.', 'info');
            });
        }
        window.updateBookingStatus = updateBookingStatus;

        async function confirmDeleteProperty(propertyId) {
            const confirmed = await showCustomConfirm('Apakah Anda yakin ingin menghapus properti ini?', 'danger');
            if (confirmed) {
                document.getElementById(`delete-form-${propertyId}`).submit();
            }
        }
        window.confirmDeleteProperty = confirmDeleteProperty;

        document.addEventListener('DOMContentLoaded', function() {
            const menuTentangSaya = document.getElementById('menu-tentang-saya');
            const menuRiwayatPenyewaan = document.getElementById('menu-riwayat-penyewaan');
            const menuPropertiSaya = document.getElementById('menu-properti-saya');
            const menuTambahProperti = document.getElementById('menu-tambah-properti');
            const menuStatusPengajuan = document.getElementById('menu-status-pengajuan');

            const routes = [
                { path: '/profile-mitra', sectionId: 'section-tentang-saya', title: 'Profile Mitra - SpotRent', menuEl: menuTentangSaya },
                { path: '/riwayat-penyewaan', sectionId: 'section-riwayat-penyewaan', title: 'Riwayat Penyewaan - SpotRent', menuEl: menuRiwayatPenyewaan },
                { path: '/properti-saya', sectionId: 'section-properti-saya', title: 'Properti Saya - SpotRent', menuEl: menuPropertiSaya },
                { path: '/tambah-properti', sectionId: 'section-tambah-properti', title: 'Tambah Properti - SpotRent', menuEl: menuTambahProperti },
                { path: '/status-pengajuan', sectionId: 'section-status-pengajuan', title: 'Status Pengajuan - SpotRent', menuEl: menuStatusPengajuan },
                { path: '/detail-riwayat-penyewaan', regex: /^\/detail-riwayat-penyewaan\/(\d+)$/, sectionId: 'section-detail-penyewaan', title: 'Detail Penyewaan - SpotRent', menuEl: menuRiwayatPenyewaan }
            ];

            SPARouter.init(routes, routes[0], (path, matched, params) => {
                if (matched.path === '/detail-riwayat-penyewaan' || matched.regex) {
                    const id = params ? params[0] : path.match(/^\/detail-riwayat-penyewaan\/(\d+)$/)[1];
                    showRentalDetail(null, id, false);
                }
                
                // Restore sidebar whenever page changes in router
                const profilePage = document.querySelector('.profile-page');
                if (profilePage) {
                    profilePage.classList.remove('sidebar-collapsed');
                }
                const btnBackCropTop = document.getElementById('btn-back-crop-top');
                if (btnBackCropTop) {
                    btnBackCropTop.style.display = 'none';
                }
            });

            // Bind click events
            const menuItems = [
                { el: menuTentangSaya, path: '/profile-mitra' },
                { el: menuRiwayatPenyewaan, path: '/riwayat-penyewaan' },
                { el: menuPropertiSaya, path: '/properti-saya' },
                { el: menuTambahProperti, path: '/tambah-properti' },
                { el: menuStatusPengajuan, path: '/status-pengajuan' }
            ];

            menuItems.forEach(item => {
                if (item.el) {
                    item.el.addEventListener('click', function(e) {
                        e.preventDefault();
                        navigateTo(item.path);
                    });
                }
            });

            // Initial load check
            const currentPath = window.location.pathname;
            if (window.activeBookingId) {
                navigateTo(`/detail-riwayat-penyewaan/${window.activeBookingId}`, false);
            } else {
                navigateTo(currentPath, false);
            }

            // Trigger check on load if old value is present (for facilities dropdown)
            updateFasilitasSelection();

            // Old category pre-selection
            const oldKategoriVal = document.getElementById('kategori-value')?.value;
            if (oldKategoriVal) {
                const matchedRow = document.querySelector(`.category-item-row[data-id="${oldKategoriVal}"]`);
                if (matchedRow) {
                    const name = matchedRow.getAttribute('data-name');
                    const iconUrl = matchedRow.getAttribute('data-icon');
                    selectKategori(oldKategoriVal, name, iconUrl);
                }
            }

            // Apply rental history filters and sort on load
            applyAllFilters();
        });

        // Apply all filters and sorting on Mitra Rental History
        function applyAllFilters() {
            const searchInputEl = document.getElementById('filter-search-input');
            const searchQuery = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
            
            const statusInputEl = document.getElementById('filter-status-value');
            const statusFilter = statusInputEl ? statusInputEl.value : 'all';
            
            const sortInputEl = document.getElementById('filter-sort-value');
            const sortBy = sortInputEl ? sortInputEl.value : 'date_desc';
            
            const bookingListContainer = document.querySelector('.booking-list');
            if (!bookingListContainer) return;
            
            const cards = Array.from(bookingListContainer.querySelectorAll('.booking-card'));
            let visibleCount = 0;
            
            cards.forEach(card => {
                const propName = card.getAttribute('data-property-name') || '';
                const tenantName = card.getAttribute('data-tenant-name') || '';
                const status = card.getAttribute('data-status') || '';
                
                // 1. Check Search Query
                const matchesSearch = searchQuery === '' || 
                                      propName.includes(searchQuery) || 
                                      tenantName.includes(searchQuery);
                                      
                // 2. Check Status Filter
                let matchesStatus = false;
                if (statusFilter === 'all') {
                    matchesStatus = true;
                } else if (statusFilter === 'pending') {
                    matchesStatus = (status === 'pending');
                } else if (statusFilter === 'confirmed') {
                    matchesStatus = (status === 'confirmed');
                } else if (statusFilter === 'completed') {
                    matchesStatus = (status === 'completed');
                } else if (statusFilter === 'rejected') {
                    matchesStatus = (status !== 'pending' && status !== 'confirmed' && status !== 'completed');
                }
                
                if (matchesSearch && matchesStatus) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Handle Empty State
            let emptyMessage = document.getElementById('empty-bookings-message');
            if (visibleCount === 0) {
                if (!emptyMessage) {
                    emptyMessage = document.createElement('div');
                    emptyMessage.id = 'empty-bookings-message';
                    emptyMessage.style.cssText = "text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;";
                    emptyMessage.textContent = "Tidak ada riwayat penyewaan yang cocok dengan filter.";
                    bookingListContainer.appendChild(emptyMessage);
                } else {
                    emptyMessage.style.display = 'block';
                }
            } else {
                if (emptyMessage) {
                    emptyMessage.style.display = 'none';
                }
            }
            
            // 3. Sort Cards
            if (visibleCount > 1) {
                cards.sort((a, b) => {
                    const statusA = a.getAttribute('data-status') || '';
                    const statusB = b.getAttribute('data-status') || '';

                    // If status filter is "all", prioritize pending at the very top
                    if (statusFilter === 'all') {
                        if (statusA === 'pending' && statusB !== 'pending') return -1;
                        if (statusA !== 'pending' && statusB === 'pending') return 1;
                    }

                    if (sortBy === 'date_desc') {
                        const valA = parseInt(a.getAttribute('data-timestamp')) || 0;
                        const valB = parseInt(b.getAttribute('data-timestamp')) || 0;
                        return valB - valA;
                    } else if (sortBy === 'date_asc') {
                        const valA = parseInt(a.getAttribute('data-timestamp')) || 0;
                        const valB = parseInt(b.getAttribute('data-timestamp')) || 0;
                        return valA - valB;
                    } else if (sortBy === 'price_desc') {
                        const valA = parseFloat(a.getAttribute('data-price')) || 0;
                        const valB = parseFloat(b.getAttribute('data-price')) || 0;
                        return valB - valA;
                    } else if (sortBy === 'price_asc') {
                        const valA = parseFloat(a.getAttribute('data-price')) || 0;
                        const valB = parseFloat(b.getAttribute('data-price')) || 0;
                        return valA - valB;
                    }
                    return 0;
                });
                
                // Re-append sorted cards in order
                cards.forEach(card => {
                    bookingListContainer.appendChild(card);
                });
            }
        }

        // Toggle Filter and Sort custom dropdowns
        function toggleFilterDropdown(id, e) {
            if (e) e.stopPropagation();
            
            // Close other dropdowns first
            ['status-dropdown', 'sort-dropdown', 'kategori-dropdown', 'fasilitas-dropdown'].forEach(dropId => {
                if (dropId !== id) {
                    const drop = document.getElementById(dropId);
                    if (drop) drop.style.display = 'none';
                }
            });
            
            const dropdown = document.getElementById(id);
            if (dropdown) {
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            }
        }

        // Select Status Filter
        function selectFilterStatus(val, label, e) {
            if (e) e.stopPropagation();
            const valInput = document.getElementById('filter-status-value');
            if (valInput) valInput.value = val;
            
            const display = document.getElementById('status-display');
            if (display) {
                if (val === 'all') {
                    display.innerHTML = 'Semua Status';
                } else {
                    let badgeClass = 'process';
                    if (val === 'confirmed') badgeClass = 'success';
                    if (val === 'completed') badgeClass = 'completed';
                    if (val === 'rejected') badgeClass = 'danger';
                    
                    display.innerHTML = `<span class="status-badge-inline ${badgeClass}">${label}</span>`;
                }
            }
            
            const dropdown = document.getElementById('status-dropdown');
            if (dropdown) dropdown.style.display = 'none';
            applyAllFilters();
        }

        // Select Sort Filter
        function selectFilterSort(val, label, e) {
            if (e) e.stopPropagation();
            const valInput = document.getElementById('filter-sort-value');
            if (valInput) valInput.value = val;
            
            const display = document.getElementById('sort-display');
            if (display) display.textContent = label;
            
            const dropdown = document.getElementById('sort-dropdown');
            if (dropdown) dropdown.style.display = 'none';
            applyAllFilters();
        }

        // Toggle category list
        function toggleKategoriDropdown(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('kategori-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        // Select category
        function selectKategori(id, name, iconUrl, e) {
            if (e) e.stopPropagation();
            const valueInput = document.getElementById('kategori-value');
            if (valueInput) {
                valueInput.value = id;
                valueInput.dispatchEvent(new Event('input'));
                
                const card = valueInput.closest('.field-card');
                if (card) {
                    card.style.borderColor = 'transparent';
                    card.style.boxShadow = '';
                }
            }

            const displayContainer = document.getElementById('kategori-display');
            if (displayContainer) {
                displayContainer.innerHTML = '';
                
                const badge = document.createElement('div');
                badge.className = 'selected-badge';
                
                const icon = document.createElement('img');
                icon.src = iconUrl;
                
                const label = document.createElement('span');
                label.textContent = name;
                
                badge.appendChild(icon);
                badge.appendChild(label);
                displayContainer.appendChild(badge);
            }

            const dropdown = document.getElementById('kategori-dropdown');
            if (dropdown) dropdown.style.display = 'none';
        }

        // Toggle facilities list
        function toggleFasilitasDropdown(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('fasilitas-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        // Update facilities text display and hidden input
        function updateFasilitasSelection() {
            const checkboxes = document.querySelectorAll('.facility-checkbox');
            const selectedNames = [];
            const displayContainer = document.getElementById('fasilitas-display');
            if (!displayContainer) return;
            displayContainer.innerHTML = '';
            
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selectedNames.push(cb.value);
                    
                    const badge = document.createElement('div');
                    badge.className = 'selected-badge';
                    
                    const icon = document.createElement('img');
                    icon.src = cb.dataset.icon;
                    
                    const label = document.createElement('span');
                    label.textContent = cb.value;
                    
                    badge.appendChild(icon);
                    badge.appendChild(label);
                    displayContainer.appendChild(badge);
                }
            });
            
            const valueInput = document.getElementById('fasilitas-value');
            if (valueInput) valueInput.value = selectedNames.join(', ');
            
            if (selectedNames.length === 0) {
                displayContainer.innerHTML = '<span style="font-size: 15px; font-weight: 500; color: #777;">Pilih Fasilitas</span>';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const container = document.getElementById('fasilitas-dropdown-container');
            const dropdown = document.getElementById('fasilitas-dropdown');
            if (container && !container.contains(e.target)) {
                if (dropdown) dropdown.style.display = 'none';
            }

            const catContainer = document.getElementById('kategori-dropdown-container');
            const catDropdown = document.getElementById('kategori-dropdown');
            if (catContainer && !catContainer.contains(e.target)) {
                if (catDropdown) catDropdown.style.display = 'none';
            }

            const statusContainer = document.getElementById('status-dropdown-container');
            const statusDropdown = document.getElementById('status-dropdown');
            if (statusContainer && !statusContainer.contains(e.target)) {
                if (statusDropdown) statusDropdown.style.display = 'none';
            }

            const sortContainer = document.getElementById('sort-dropdown-container');
            const sortDropdown = document.getElementById('sort-dropdown');
            if (sortContainer && !sortContainer.contains(e.target)) {
                if (sortDropdown) sortDropdown.style.display = 'none';
            }
        });

        // Price formatting logic (Indonesian Rupiah formatting)
        const displayInput = document.getElementById('harga_display');
        const hiddenInput = document.getElementById('harga_per_hari');

        function formatRupiah(value) {
            let number = value.replace(/[^0-9]/g, '');
            if (number === '') return '';
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        if (displayInput) {
            displayInput.addEventListener('input', function(e) {
                let rawVal = this.value.replace(/[^0-9]/g, '');
                this.value = formatRupiah(this.value);
                if (hiddenInput) hiddenInput.value = rawVal;
            });

            if (hiddenInput && hiddenInput.value) {
                displayInput.value = formatRupiah(hiddenInput.value);
            }
        }

        // STEP NAVIGATION
        let activeSubStep = 'upload';

        function goToSubStep(subStep) {
            const stepUpload = document.getElementById('sub-step-upload');
            const stepCrop = document.getElementById('sub-step-crop');
            const profilePage = document.querySelector('.profile-page');
            if (!stepUpload || !stepCrop) return;

            if (subStep === 'crop') {
                if (selectedFiles.length < 2) {
                    showProfileToast('Minimal 2 foto wajib diunggah untuk mengatur posisi.');
                    return;
                }
                activeSubStep = 'crop';
                stepUpload.style.display = 'none';
                stepCrop.style.display = 'flex';
                renderLiveLayoutPreview();
                
                // Hide sidebar with animation
                if (profilePage) {
                    profilePage.classList.add('sidebar-collapsed');
                }
                const btnBackCropTop = document.getElementById('btn-back-crop-top');
                if (btnBackCropTop) {
                    btnBackCropTop.style.display = 'inline-flex';
                }
            } else {
                activeSubStep = 'upload';
                stepUpload.style.display = 'flex';
                stepCrop.style.display = 'none';
                
                // Restore sidebar
                if (profilePage) {
                    profilePage.classList.remove('sidebar-collapsed');
                }
                const btnBackCropTop = document.getElementById('btn-back-crop-top');
                if (btnBackCropTop) {
                    btnBackCropTop.style.display = 'none';
                }
            }
            
            // Scroll to the form section top seamlessly
            const targetSec = document.getElementById('section-tambah-properti');
            if (targetSec) {
                targetSec.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function goToStep(step) {
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            
            if (step === 2) {
                // Validate required inputs in step 1
                const requiredInputs = step1.querySelectorAll('[required]');
                let valid = true;
                requiredInputs.forEach(input => {
                    const card = input.closest('.field-card');
                    if (!input.value.trim()) {
                        valid = false;
                        if (card) {
                            card.style.borderColor = '#ef4444';
                            card.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
                        }
                    } else {
                        if (card) {
                            card.style.borderColor = 'transparent';
                            card.style.boxShadow = '';
                        }
                    }

                    // Clear highlight realtime saat user mulai mengetik
                    input.addEventListener('input', function () {
                        if (card && this.value.trim()) {
                            card.style.borderColor = 'transparent';
                            card.style.boxShadow = '';
                        }
                    }, { once: false });
                });

                if (!valid) {
                    showProfileToast('Mohon lengkapi semua data spesifikasi properti terlebih dahulu.');
                    // Scroll ke field pertama yang kosong
                    const firstEmpty = step1.querySelector('[required]:placeholder-shown, input[required][value=""]');
                    if (firstEmpty) {
                        firstEmpty.closest('.field-card')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return;
                }

                step1.style.display = 'none';
                step2.style.display = 'block';
                document.getElementById('form-title').textContent = 'Tambah Foto Properti';
                
                // Default to upload sub-step
                goToSubStep('upload');
            } else {
                step1.style.display = 'block';
                step2.style.display = 'none';
                document.getElementById('form-title').textContent = 'Tambah Properti';
                
                // Restore sidebar when leaving step 2
                const profilePage = document.querySelector('.profile-page');
                if (profilePage) {
                    profilePage.classList.remove('sidebar-collapsed');
                }
                const btnBackCropTop = document.getElementById('btn-back-crop-top');
                if (btnBackCropTop) {
                    btnBackCropTop.style.display = 'none';
                }
            }
        }

        // PHOTO UPLOAD DRAG & DROP
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('property-images');
        const countLabel = document.getElementById('photo-count-label');
        const uploadPhotoList = document.getElementById('uploadPhotoList');
        const photoControlList = document.getElementById('photoControlList');
        const previewGalleryContainer = document.getElementById('previewGalleryContainer');
        const liveLayoutGallery = document.getElementById('liveLayoutGallery');
        const hiddenPositionsContainer = document.getElementById('hidden-positions-container');
        let selectedFiles = []; // Array of { file: File, positionX: number, positionY: number, previewUrl: string }

        if (dropzone) {
            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('dragover');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('dragover');
            });

            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('dragover');
                if (e.dataTransfer.files.length > 0) {
                    handleFiles(e.dataTransfer.files);
                }
            });
        }

        function handleFileSelect(e) {
            handleFiles(e.target.files);
        }

        function handleFiles(files) {
            if (!fileInput) return;
            const newFiles = Array.from(files);
            
            for (let file of newFiles) {
                if (selectedFiles.length >= 5) break;
                if (!file.type.startsWith('image/')) continue;
                selectedFiles.push({
                    file: file,
                    positionX: 50,
                    positionY: 50,
                    previewUrl: URL.createObjectURL(file)
                });
            }
            
            updateFormInputsAndPreviews();
        }

        function updateFormInputsAndPreviews() {
            if (!fileInput || !countLabel || !hiddenPositionsContainer) return;
            
            // Sync files list to input field
            const dt = new DataTransfer();
            selectedFiles.forEach(item => dt.items.add(item.file));
            fileInput.files = dt.files;

            // Sync hidden inputs for positions
            hiddenPositionsContainer.innerHTML = '';
            selectedFiles.forEach(item => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'positions[]';
                hiddenInput.value = `${item.positionX || 50}% ${item.positionY || 50}%`;
                hiddenPositionsContainer.appendChild(hiddenInput);
            });

            // Update photo count text
            if (selectedFiles.length > 0) {
                countLabel.textContent = `${selectedFiles.length} foto terpilih (Minimal 2, Maksimal 5)`;
            } else {
                countLabel.textContent = 'Belum ada foto terpilih (Minimal 2, Maksimal 5)';
            }

            // Sync navigation button disabled state in Upload Stage
            const btnToCrop = document.getElementById('btn-to-crop');
            if (btnToCrop) {
                if (selectedFiles.length >= 2) {
                    btnToCrop.disabled = false;
                    btnToCrop.style.opacity = '1';
                    btnToCrop.style.cursor = 'pointer';
                } else {
                    btnToCrop.disabled = true;
                    btnToCrop.style.opacity = '0.5';
                    btnToCrop.style.cursor = 'not-allowed';
                }
            }

            // If we are currently in crop step but photo count drops below 2, automatically fallback to upload sub-step
            if (activeSubStep === 'crop' && selectedFiles.length < 2) {
                goToSubStep('upload');
            }

            // 1. Render Sub-step 2A Upload List
            if (uploadPhotoList) {
                uploadPhotoList.innerHTML = '';
                selectedFiles.forEach((item, index) => {
                    const card = document.createElement('div');
                    card.className = 'upload-item-card';

                    // Thumb preview
                    const thumb = document.createElement('div');
                    thumb.className = 'upload-item-thumb';
                    const img = document.createElement('img');
                    img.src = item.previewUrl;
                    thumb.appendChild(img);
                    card.appendChild(thumb);

                    // Information
                    const info = document.createElement('div');
                    info.className = 'upload-item-info';

                    const title = document.createElement('div');
                    title.className = 'upload-item-title';
                    
                    const filenameSpan = document.createElement('span');
                    filenameSpan.className = 'upload-item-filename';
                    filenameSpan.textContent = item.file.name;
                    filenameSpan.title = item.file.name;
                    title.appendChild(filenameSpan);

                    const badge = document.createElement('span');
                    if (index === 0) {
                        badge.className = 'badge-cover';
                        badge.textContent = 'Foto Utama (Cover)';
                    } else {
                        badge.className = 'badge-secondary';
                        badge.textContent = `Foto Detail #${index + 1}`;
                    }
                    title.appendChild(badge);
                    info.appendChild(title);
                    card.appendChild(info);

                    // Reordering & deletion actions
                    const actions = document.createElement('div');
                    actions.className = 'upload-item-actions';

                    if (index > 0) {
                        const btnUp = document.createElement('button');
                        btnUp.type = 'button';
                        btnUp.className = 'btn-action';
                        btnUp.textContent = '◀';
                        btnUp.title = 'Pindahkan Ke Kiri';
                        btnUp.onclick = () => swapFiles(index, index - 1);
                        actions.appendChild(btnUp);
                    }

                    if (index < selectedFiles.length - 1) {
                        const btnDown = document.createElement('button');
                        btnDown.type = 'button';
                        btnDown.className = 'btn-action';
                        btnDown.textContent = '▶';
                        btnDown.title = 'Pindahkan Ke Kanan';
                        btnDown.onclick = () => swapFiles(index, index + 1);
                        actions.appendChild(btnDown);
                    }

                    const btnDel = document.createElement('button');
                    btnDel.type = 'button';
                    btnDel.className = 'btn-action btn-delete';
                    btnDel.textContent = 'Hapus';
                    btnDel.onclick = () => removeFile(index);
                    actions.appendChild(btnDel);

                    card.appendChild(actions);
                    uploadPhotoList.appendChild(card);
                });
            }

            // 2. Render Sub-step 2B Crop Controls List (Table Rows)
            if (photoControlList) {
                photoControlList.innerHTML = '';
                selectedFiles.forEach((item, index) => {
                    const row = document.createElement('tr');

                    // 1. Thumbnail cell
                    const tdThumb = document.createElement('td');
                    const thumb = document.createElement('div');
                    thumb.className = 'crop-table-thumb';
                    const img = document.createElement('img');
                    img.src = item.previewUrl;
                    img.id = `preview-thumb-img-${index}`;
                    thumb.appendChild(img);
                    tdThumb.appendChild(thumb);
                    row.appendChild(tdThumb);

                    // 2. Info cell
                    const tdInfo = document.createElement('td');
                    const info = document.createElement('div');
                    info.className = 'crop-table-info';
                    
                    const filenameSpan = document.createElement('span');
                    filenameSpan.className = 'crop-table-filename';
                    filenameSpan.textContent = item.file.name;
                    filenameSpan.title = item.file.name;
                    info.appendChild(filenameSpan);

                    const badge = document.createElement('span');
                    if (index === 0) {
                        badge.className = 'badge-cover';
                        badge.textContent = 'Foto Utama (Cover)';
                    } else {
                        badge.className = 'badge-secondary';
                        badge.textContent = `Foto Detail #${index + 1}`;
                    }
                    info.appendChild(badge);
                    tdInfo.appendChild(info);
                    row.appendChild(tdInfo);

                    // 3. Horizontal Slider cell
                    const tdSliderX = document.createElement('td');
                    tdSliderX.className = 'crop-table-slider-cell';
                    const adjusterX = document.createElement('div');
                    adjusterX.className = 'crop-table-adjuster';
                    
                    const sliderX = document.createElement('input');
                    sliderX.type = 'range';
                    sliderX.className = 'crop-slider';
                    sliderX.min = '0';
                    sliderX.max = '100';
                    sliderX.value = item.positionX || 50;
                    
                    const valDisplayX = document.createElement('span');
                    valDisplayX.style.width = '30px';
                    valDisplayX.style.textAlign = 'right';
                    valDisplayX.style.fontSize = '12px';
                    valDisplayX.style.fontWeight = '600';
                    valDisplayX.style.color = '#4b5563';
                    valDisplayX.textContent = `${sliderX.value}%`;

                    adjusterX.appendChild(sliderX);
                    adjusterX.appendChild(valDisplayX);
                    tdSliderX.appendChild(adjusterX);
                    row.appendChild(tdSliderX);

                    // 4. Vertical Slider cell
                    const tdSliderY = document.createElement('td');
                    tdSliderY.className = 'crop-table-slider-cell';
                    const adjusterY = document.createElement('div');
                    adjusterY.className = 'crop-table-adjuster';
                    
                    const sliderY = document.createElement('input');
                    sliderY.type = 'range';
                    sliderY.className = 'crop-slider';
                    sliderY.min = '0';
                    sliderY.max = '100';
                    sliderY.value = item.positionY || 50;
                    
                    const valDisplayY = document.createElement('span');
                    valDisplayY.style.width = '30px';
                    valDisplayY.style.textAlign = 'right';
                    valDisplayY.style.fontSize = '12px';
                    valDisplayY.style.fontWeight = '600';
                    valDisplayY.style.color = '#4b5563';
                    valDisplayY.textContent = `${sliderY.value}%`;

                    adjusterY.appendChild(sliderY);
                    adjusterY.appendChild(valDisplayY);
                    tdSliderY.appendChild(adjusterY);
                    row.appendChild(tdSliderY);

                    function updateImagePositions() {
                        const valX = sliderX.value;
                        const valY = sliderY.value;
                        item.positionX = valX;
                        item.positionY = valY;
                        valDisplayX.textContent = `${valX}%`;
                        valDisplayY.textContent = `${valY}%`;
                        
                        const posStr = `${valX}% ${valY}%`;
                        
                        // Update layout preview live (mock gallery image position shifts, thumbnail is locked via CSS)
                        const galleryImg = document.getElementById(`gallery-img-${index}`);
                        if (galleryImg) {
                            galleryImg.style.objectPosition = posStr;
                        }

                        // Update corresponding hidden input value
                        if (hiddenPositionsContainer && hiddenPositionsContainer.children && hiddenPositionsContainer.children[index]) {
                            hiddenPositionsContainer.children[index].value = posStr;
                        }
                    }

                    sliderX.oninput = updateImagePositions;
                    sliderY.oninput = updateImagePositions;

                    photoControlList.appendChild(row);
                });
            }

            // 3. Update/Toggle Live Layout Preview visibility
            if (previewGalleryContainer) {
                if (selectedFiles.length >= 2) {
                    previewGalleryContainer.style.display = 'block';
                    if (activeSubStep === 'crop') {
                        renderLiveLayoutPreview();
                    }
                } else {
                    previewGalleryContainer.style.display = 'none';
                }
            }
        }

        function swapFiles(idx1, idx2) {
            const temp = selectedFiles[idx1];
            selectedFiles[idx1] = selectedFiles[idx2];
            selectedFiles[idx2] = temp;
            updateFormInputsAndPreviews();
        }

        function removeFile(index) {
            if (selectedFiles[index]) {
                URL.revokeObjectURL(selectedFiles[index].previewUrl);
                selectedFiles.splice(index, 1);
            }
            updateFormInputsAndPreviews();
        }

        function renderLiveLayoutPreview() {
            if (!liveLayoutGallery) return;
            liveLayoutGallery.innerHTML = '';

            const n = selectedFiles.length; // Range [2, 5]
            const galleryDiv = document.createElement('div');
            galleryDiv.className = `mock-gallery mock-gallery-${n}`;

            // Main / Cover slot (Slot 1)
            const mainItem = document.createElement('div');
            mainItem.className = 'mock-gallery-item mock-main-item';
            
            const mainImg = document.createElement('img');
            mainImg.src = selectedFiles[0].previewUrl;
            mainImg.style.objectPosition = `${selectedFiles[0].positionX || 50}% ${selectedFiles[0].positionY || 50}%`;
            mainImg.id = 'gallery-img-0';
            mainItem.appendChild(mainImg);

            const mainLabel = document.createElement('div');
            mainLabel.className = 'slot-label';
            mainLabel.textContent = 'Foto 1: Cover (Utama)';
            mainItem.appendChild(mainLabel);

            galleryDiv.appendChild(mainItem);

            // Side slots
            if (n > 1) {
                const sideGallery = document.createElement('div');
                sideGallery.className = 'mock-side-gallery';

                for (let i = 1; i < n; i++) {
                    const sideItem = document.createElement('div');
                    sideItem.className = 'mock-gallery-item';
                    
                    const sideImg = document.createElement('img');
                    sideImg.src = selectedFiles[i].previewUrl;
                    sideImg.style.objectPosition = `${selectedFiles[i].positionX || 50}% ${selectedFiles[i].positionY || 50}%`;
                    sideImg.id = `gallery-img-${i}`;
                    sideItem.appendChild(sideImg);

                    const sideLabel = document.createElement('div');
                    sideLabel.className = 'slot-label';
                    sideLabel.textContent = `Foto ${i + 1}`;
                    sideItem.appendChild(sideLabel);

                    sideGallery.appendChild(sideItem);
                }
                galleryDiv.appendChild(sideGallery);
            }

            liveLayoutGallery.appendChild(galleryDiv);
        }

        function scrollToPreview(e) {
            if (e) e.preventDefault();
            const el = document.getElementById('previewGalleryContainer');
            if (el) {
                el.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Add client-side validation to form submission
        const propertyForm = document.getElementById('propertyForm');
        if (propertyForm) {
            propertyForm.addEventListener('submit', function (e) {
                if (selectedFiles.length < 2) {
                    e.preventDefault();
                    showProfileToast('Minimal 2 foto wajib diunggah untuk melanjutkan.');
                } else if (selectedFiles.length > 5) {
                    e.preventDefault();
                    showProfileToast('Maksimal 5 foto dapat diunggah.');
                }
            });
        }

        // =============================================
        // VALIDASI FORM PROFIL MITRA
        // =============================================
        let profileToastTimer = null;

        function showProfileToast(msg) {
            const overlay = document.getElementById('profile-toast-overlay');
            const box = document.getElementById('profile-toast-box');
            const msgEl = document.getElementById('profile-toast-msg');
            if (!overlay || !box) return;

            msgEl.textContent = msg || 'Mohon lengkapi semua data profil terlebih dahulu.';
            overlay.style.display = 'block';

            // Trigger animation
            requestAnimationFrame(() => {
                box.style.opacity = '1';
                box.style.transform = 'translateX(-50%) translateY(0)';
            });

            // Auto-dismiss setelah 4 detik
            clearTimeout(profileToastTimer);
            profileToastTimer = setTimeout(() => closeProfileToast(), 4000);
        }

        function closeProfileToast() {
            const overlay = document.getElementById('profile-toast-overlay');
            const box = document.getElementById('profile-toast-box');
            if (!overlay || !box) return;

            box.style.opacity = '0';
            box.style.transform = 'translateX(-50%) translateY(-20px)';
            setTimeout(() => { overlay.style.display = 'none'; }, 300);
        }

        const profileMitraForm = document.getElementById('profile-mitra-form');
        if (profileMitraForm) {
            profileMitraForm.addEventListener('submit', function (e) {
                const requiredInputs = profileMitraForm.querySelectorAll('input[required]');
                let valid = true;

                requiredInputs.forEach(input => {
                    const card = input.closest('.field-card');
                    if (!input.value.trim()) {
                        valid = false;
                        if (card) {
                            card.style.borderColor = '#ef4444';
                            card.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
                        }
                    } else {
                        if (card) {
                            card.style.borderColor = 'transparent';
                            card.style.boxShadow = '';
                        }
                    }

                    // Clear highlight realtime saat user mulai mengetik
                    input.addEventListener('input', function () {
                        if (card && this.value.trim()) {
                            card.style.borderColor = 'transparent';
                            card.style.boxShadow = '';
                        }
                    }, { once: false });
                });

                if (!valid) {
                    e.preventDefault();
                    showProfileToast('Mohon lengkapi semua data profil terlebih dahulu.');
                    // Scroll ke field pertama yang kosong
                    const firstEmpty = profileMitraForm.querySelector('input[required]:placeholder-shown, input[required][value=""]');
                    if (firstEmpty) {
                        firstEmpty.closest('.field-card')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        }
    </script>
@endsection
