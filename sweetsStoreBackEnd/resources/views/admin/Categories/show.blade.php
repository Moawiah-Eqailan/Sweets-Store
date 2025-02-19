@extends('layouts.app')


@section('contents')
    <div class="create-category-container">
        <div class="form-card">
            <div class="form-header">
                <h2 class="form-title">
                    <i class="fas fa-folder-open me-2"></i>
                    تفاصيل الفئة
                </h2>
                <p class="form-subtitle">عرض معلومات الفئة</p>
            </div>
        
            <div class="category-form">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tag me-2" style="margin: 8px;"></i>
                        اسم الفئة
                    </label>
                    <input type="text" name="category_name" class="form-input" value="{{ $category->category_name }}" readonly disabled>
                </div>
        
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-image me-2" style="margin: 8px;"></i>
                        صورة الفئة
                    </label>
                    <div class="image-preview">
                        <img src="{{ asset('storage/' . $category->category_image) }}" alt="صورة الفئة" class="detail-image">
                    </div>
                </div>
        
                <div class="timestamp-group">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-plus me-2" style="margin: 8px;"></i>
                            تاريخ الإنشاء
                        </label>
                        <input type="text" name="created_at" class="form-input" value="{{ $category->created_at }}" readonly disabled>
                    </div>
        
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-check me-2" style="margin: 8px;"></i>
                            تاريخ التحديث
                        </label>
                        <input type="text" name="updated_at" class="form-input" value="{{ $category->updated_at }}" readonly disabled>
                    </div>
                </div>
        
                <div class="form-actions">
                    <a href="{{ route('Categories') }}" class="return-btn">
                        <i class="fas fa-arrow-left me-2" style="margin: 8px;"></i>
                        العودة إلى الوراء
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
