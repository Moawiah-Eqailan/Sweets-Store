@extends('layouts.app')


@section('title', 'messages ')

@section('contents')
<div class="messages-container">
    {{-- <div class="page-header">
        <div class="header-content">
            <h3 class="page-title">رسائل التواصل</h3>
        </div>
    </div> --}}

    <div class="table-container">
        <table class="categories-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @if($contactMessages->count() > 0)
                @foreach($contactMessages as $contact)
                <tr class="category-row">
                    <td>
                        <span class="id-badge">{{ $loop->iteration }}</span>
                    </td>
                    <td>
                        <div class="user-name">
                            <i class="fas fa-user message-icon"></i>
                            {{ $contact->user_name }}
                        </div>
                    </td>

                    <td>
                        <div class="user-email">
                            <i class="fas fa-at message-icon"></i>
                            {{ $contact->user_email }}
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('Contact.show', $contact->id) }}" class="action-btn view-btn" title="عرض التفاصيل">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(Session::has('success'))
                            <script>
                                Swal.fire({
                                    title: 'نجاح!',
                                    text: '{{ Session::get("success") }}',
                                    icon: 'success',
                                    confirmButtonText: 'حسنًا'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '{{ route("Contact") }}';
                                    }
                                });
                            </script>
                            @endif
                            <form id="delete-form-{{ $contact->id }}" action="{{ route('Contact.destroy', $contact->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" class="action-btn delete-btn" onclick="confirmDelete('{{ $contact->id }}')" title="حذف">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>

                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="4" class="empty-state">
                        <div class="empty-state-content">
                            <i class="fas fa-inbox empty-icon"></i>
                            <p>لم يتم العثور على رسائل</p>
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>


<style>
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .delete-btn {
        background: #B1A05A;
    }

    .delete-btn:hover {
        background: #A89D4D;
        color: white;
    }

    .action-btn {
        padding: 0.5rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
    }

    .view-btn {
        background: #36b9cc;
    }

    .view-btn:hover {
        background: #2c94a3;
        color: white;
    }

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
        width: 250px;

    }

    .table-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .categories-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
    }

    .categories-table th {
        background: #f8f9fc;
        color: #B1A05A;
        padding: 1rem;
        font-weight: 600;
        text-align: left;
    }

    .category-row {
        transition: all 0.3s ease;
    }

    .category-row:hover {
        background: #f8f9fc;
        transform: translateX(5px);
    }

    .category-row td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e3e6f0;
    }

    .id-badge {
        background: #B1A05A;
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .user-name,
    .message-content,
    .user-email {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #5a5c69;
    }

    .message-icon {
        color: #B1A05A;
        font-size: 0.9rem;
    }

    .message-content {
        max-width: 400px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
    }

    .empty-state-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        color: #858796;
    }

    .empty-icon {
        font-size: 3rem;
        color: #dddfeb;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .messages-container {
            padding: 1rem;
        }

        .message-content {
            max-width: 200px;
        }

        .categories-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>



<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'حذف الرسالة؟',
            text: "لا يمكن التراجع عن هذا الإجراء",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: 'نعم، احذفها',
            cancelButtonText: 'إلغاء',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>

@endsection