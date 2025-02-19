@extends('layouts.app')


@section('contents')
    <div class="create-category-container">
        <div class="form-card">
            <div class="form-header">
                <h2 class="form-title">
                    <i class="fas fa-box me-2"></i>
                    اضافة فرع جديدة
                </h2>
                <p class="form-subtitle">إضافة فرع جديد إلى مخزونك</p>
            </div>

            <form action="{{ route('Items.store') }}" method="POST" enctype="multipart/form-data" class="category-form">
                @csrf
                <div class="form-group-row">
                    <div class="form-group half-width">
                        <label class="form-label">
                            <i class="fas fa-tag me-2" style="margin: 8px;"></i>
                            الاسم
                        </label>
                        <input type="text" name="item_name" class="form-input" placeholder="Enter item name..."
                            value="{{ old('item_name') }}" required>
                    </div>

             
                </div>

          

                <div class="form-group-row">
                    <div class="form-group half-width">
                        <label class="form-label">
                            <i class="fas fa-list me-2" style="margin: 8px;"></i>
                            اسم الفئة </label>
                        <select name="category_id" class="form-input">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($category as $id => $name)
                                <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-image me-2" style="margin: 8px;"></i>
                        تحميل الصورة </label>
                    <div class="file-upload-wrapper">
                        <div class="file-upload-preview" id="imagePreview">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <p class="upload-text">اضغط هنا لتحميل الصوره </p>
                        </div>
                        <input type="file" name="item_image" id="image" class="file-upload-input" accept="image/*"
                            required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('Items') }}" class="cancel-btn">
                        <i class="fas fa-times me-2" style="margin: 8px;"></i>
                        الغاء
                    </a>
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-check me-2" style="margin: 8px;"></i>
                        انشاء فرع جديد
                    </button>
                </div>
            </form>
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
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #B1A05A;
            box-shadow: 0 0 0 3px rgba(177, 160, 90, 0.1);
        }

        .file-upload-wrapper {
            position: relative;
        }

        .file-upload-preview {
            border: 2px dashed #e3e6f0;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-preview:hover {
            border-color: #B1A05A;
            background: #f8f9fc;
        }

        .upload-icon {
            font-size: 2rem;
            color: #B1A05A;
            margin-bottom: 1rem;
        }

        .upload-text {
            color: #858796;
            margin: 0;
        }

        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .cancel-btn,
        .submit-btn {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .cancel-btn {
            background: #e74a3b;
            color: #f8f9fc;
            border: 2px solid #e3e6f0;
            transform: .3s;
        }

        .cancel-btn:hover {
            background: #c11000;
            color: #f8f9fc;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .submit-btn {
            background: linear-gradient(45deg, #B1A05A, #A89D4D);
            color: white;
            border: none;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: linear-gradient(45deg, #A89D4D, #8B7C3E);
            transform: translateY(-2px);
        }
    </style>
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = `
                <img src="${e.target.result}" 
                     style="max-width: 100%; max-height: 200px; border-radius: 8px;" 
                     alt="Preview">
            `;
                }

                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = `
            <i class="fas fa-cloud-upload-alt upload-icon"></i>
            <p class="upload-text">Click or drag image to upload</p>
        `;
            }
        });
    </script>
@endsection
