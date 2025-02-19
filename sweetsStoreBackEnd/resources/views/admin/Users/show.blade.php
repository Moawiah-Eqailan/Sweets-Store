@extends('layouts.app')


@section('contents')
<div class="create-user-container">
    <div class="form-card">
        <div class="form-header">
            <h2 class="form-title">
                <i class="fas fa-user me-2"></i>
                تفاصيل المستخدم
            </h2>
            <p class="form-subtitle">عرض معلومات المستخدم</p>
        </div>

        <div class="user-form">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user me-2" style="margin: 8px;"></i>
                            الاسم
                        </label>
                        <input type="text"
                            name="name"
                            class="form-input"
                            value="{{ $users->name }}"
                            readonly disabled>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-envelope me-2" style="margin: 8px;"></i>
                            البريد الإلكتروني
                        </label>
                        <input type="text"
                            name="email"
                            class="form-input"
                            value="{{ $users->email }}"
                            readonly disabled>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-phone me-2" style="margin: 8px;"></i>
                            الهاتف
                        </label>
                        <input type="text"
                            name="phone"
                            class="form-input"
                            value="{{ $users->phone }}"
                            readonly disabled>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt me-2" style="margin: 8px;"></i>
                            العنوان
                        </label>
                        <input type="text"
                            name="address"
                            class="form-input"
                            value="{{ $users->address }}"
                            readonly disabled>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-city me-2" style="margin: 8px;"></i>
                            المدينة
                        </label>
                        <input type="text"
                            name="city"
                            class="form-input"
                            value="{{ $users->city }}"
                            readonly disabled>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt me-2" style="margin: 8px;"></i>
                            الولاية / المحافظة
                        </label>
                        <input type="text"
                            name="state"
                            class="form-input"
                            value="{{ $users->state }}"
                            readonly disabled>
                    </div>
                </div>
            </div>

            <div class="timestamp-group">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-plus me-2" style="margin: 8px;"></i>
                        تاريخ الإنشاء
                    </label>
                    <input type="text"
                        name="created_at"
                        class="form-input"
                        value="{{ $users->created_at }}"
                        readonly disabled>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-check me-2" style="margin: 8px;"></i>
                        آخر تحديث
                    </label>
                    <input type="text"
                        name="updated_at"
                        class="form-input"
                        value="{{ $users->updated_at }}"
                        readonly disabled>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('Users') }}" class="return-btn">
                    العودة إلى الوراء
                    <i class="fas fa-arrow-left me-2" style="margin: 8px;"></i>
                </a>
            </div>
        </div>

    </div>
</div>


    <style>
        .create-category-container {
            padding: 2rem;
            background-color: #f8f9fc;
            min-height: calc(100vh - 100px);
        }

        .form-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-title {
            color: #B1A05A;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: #858796;
            font-size: 1rem;
        }

        .category-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #B1A05A;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .form-input {
            padding: 0.8rem 1rem;
            border: 2px solid #e3e6f0;
            border-radius: 10px;
            font-size: 1rem;
            background-color: #f8f9fc;
        }

        .form-input[readonly] {
            cursor: default;
        }

        .image-preview {
            border: 2px solid #e3e6f0;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
        }

        .detail-image {
            max-width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 8px;
        }

        .timestamp-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-actions {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        .return-btn {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
            background: linear-gradient(45deg, #B1A05A, #A89D4D);
            color: white;
            border: none;
            cursor: pointer;
        }

        .return-btn:hover {
            background: linear-gradient(45deg, #A89D4D, #8B7C3E);
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }

        @media (max-width: 768px) {
            .timestamp-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
