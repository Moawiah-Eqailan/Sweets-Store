@extends('layouts.app')


@section('contents')

<form method="POST" enctype="multipart/form-data" id="profile_setup_frm" action="">
    <div class="profile-container">
        <div class="form-card">
            <div class="form-header">
                <h2 class="form-title">
                    <i class="fas fa-user me-2"></i>
                    تفاصيل الملف الشخصي
                    </h2>
                    <p class="form-subtitle">عرض معلومات ملفك الشخصي</p> 
            </div>

            <div class="profile-form">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user me-2" style="margin: 8px;"></i>
                        الاسم
                    </label>
                    <input type="text" name="name" class="form-input" disabled placeholder="First Name" value="{{ auth()->user()->name }}">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope me-2" style="margin: 8px;"></i>
                        البريد الأكتروني 
                    </label>
                    <input type="text" name="email" disabled class="form-input" placeholder="Email" value="{{ auth()->user()->email }}">
                </div>


            </div>
        </div>
    </div>
</form>

<style>
    .profile-container {
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

    .profile-form {
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

    .form-input[disabled] {
        cursor: default;
    }

    .form-actions {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }

    .save-btn {
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        background: linear-gradient(45deg, #B1A05A, #A89D4D);
        color: white;
        border: none;
        cursor: pointer;
    }

    .save-btn:hover {
        background: linear-gradient(45deg, #A89D4D, #8B7C3E);
        transform: translateY(-2px);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .form-group {
            flex-direction: column;
        }
    }
</style>

@endsection