@extends('layouts.app')

@section('contents')
<div class="messages-container">
    <div class="page-header">
        <div class="header-content">
            <h3 class="page-title">تفاصيل الرسالة</h3>
        </div>
    </div>

    <div class="message-details-container">
        <div class="sender-info">
            <div class="info-header">
                <i class="fas fa-user message-icon"></i>
                <h4>اسم المرسل</h4>
            </div>
            <div class="info-content">
                {{ $contact->user_name }}
            </div>
        </div>

        <div class="message-content">
            <div class="info-header">
                <i class="fas fa-envelope message-icon"></i>
                <h4>الرسالة</h4>
            </div>
            <div class="textarea-wrapper">
                <textarea 
                    class="message-textarea"
                    name="description"
                    readonly 
                    disabled>{{ $contact->message }}</textarea>
            </div>
        </div>

        <div class="message-content">
            <div class="info-header">
                <i class="fas fa-phone"></i>
                <h4>الهاتف</h4>
            </div>
            <div class="info-content">
                {{ $contact->user_phone }}
            </div>
        </div>
        <div class="message-content">
            <div class="info-header">
                <i class="fas fa-tag"></i>
                <h4>الموضوع</h4>
            </div>
            <div class="info-content">
                {{ $contact->subject }}
            </div>
        </div>
        <div class="message-content">
            <div class="info-header">
                <i class="fas fa-envelope"></i>
                <h4>البريد الإلكتروني</h4>
            </div>
            <div class="info-content">
                {{ $contact->user_email }}
            </div>
        </div>

    </div>
</div>

<style>
    .messages-container {
        padding: 1.5rem;
        background-color: #f8f9fc;
        min-height: 100vh;
    }

    .page-header {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        font-size: 1.5rem;
        color: #B1A05A;
        margin: 0;
        font-weight: 600;
    }

    .message-details-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .sender-info, .message-content {
        margin-bottom: 2rem;
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: #B1A05A;
    }

    .info-header h4 {
        margin: 0;
        font-size: 1.1rem;
    }

    .message-icon {
        color: #B1A05A;
        font-size: 1rem;
    }

    .info-content {
        background-color: #f8f9fc;
        padding: 1rem;
        border-radius: 10px;
        border: 1px solid #e3e6f0;
        color: #5a5c69;
        line-height: 1.5;
    }

    .textarea-wrapper {
        width: 100%;
    }

    .message-textarea {
        width: 100%;
        min-height: 150px;
        padding: 1rem;
        background-color: #f8f9fc;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        color: #5a5c69;
        font-family: inherit;
        font-size: 1rem;
        line-height: 1.5;
        resize: vertical;
    }

    .message-textarea:disabled {
        cursor: default;
        opacity: 0.9;
        background-color: #f8f9fc;
    }

    .message-textarea:focus {
        outline: none;
        border-color: #B1A05A;
    }

    @media (max-width: 768px) {
        .messages-container {
            padding: 1rem;
        }

        .message-textarea {
            min-height: 120px;
        }
    }
</style>

@endsection