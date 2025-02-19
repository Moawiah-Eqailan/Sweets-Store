@extends('layouts.app')

@section('title', 'products')

@section('contents')
    <div class="products-container">
        <div class="page-header">
            <div class="header-content">
                <div class="header-actions">
                    <form class="search-form" method="GET" action="{{ route('search') }}">
                        <div class="search-wrapper">
                            <input type="text" name="query" class="search-input"
                                placeholder="ابحث باسم المنتج أو الفئة...">
                            <button class="search-button" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    <a href="{{ route('products.create') }}" class="add-button">
                        <i class="fas fa-plus me-2" style="margin: 8px;"></i>
                        إضافة منتج جديد
                    </a>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>صورة المنتج</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($product->count() > 0)
                        @foreach ($product as $rs)
                            <tr class="product-row">
                                <td>
                                    <span class="id-badge">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="product-name">
                                        {{ $rs->product_name }}
                                    </div>
                                </td>
                                <td>
                                    <div class="image-container">
                                        <img src="{{ asset('storage/' . $rs->product_image) }}" class="product-image"
                                            alt="{{ $rs->product_name }}" style="object-fit: contain;">
                                    </div>

                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('products.show', $rs->product_id) }}" class="action-btn view-btn"
                                            title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if (Session::has('success'))
                                            <script>
                                                Swal.fire({
                                                    title: 'نجاح!',
                                                    text: '{{ Session::get('success') }}',
                                                    icon: 'success',
                                                    confirmButtonText: 'موافق'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = '{{ route('products') }}';
                                                    }
                                                });
                                            </script>
                                        @endif
                                        @if (session('error'))
                                            <script>
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'عفوًا...',
                                                    text: '{{ session('error') }}'
                                                });
                                            </script>
                                        @endif
                                        <a href="{{ route('products.edit', $rs->product_id) }}" class="action-btn edit-btn"
                                            title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="action-btn delete-btn"
                                            onclick="confirmDelete('{{ $rs->product_id }}')" title="حذف">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="empty-state-content">
                                    <i class="fas fa-box-open empty-icon"></i>
                                    <p>لا توجد منتجات</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if ($product instanceof \Illuminate\Pagination\LengthAwarePaginator && $product->lastPage() > 1)
                <div class="pagination-container">
                    <ul class="pagination">
                        @if ($product->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $product->previousPageUrl() }}"
                                    rel="prev">&laquo;</a></li>
                        @endif

                        @foreach (range(1, $product->lastPage()) as $i)
                            <li class="page-item {{ $product->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $product->url($i) }}">{{ $i }}</a>
                            </li>
                        @endforeach

                        @if ($product->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $product->nextPageUrl() }}"
                                    rel="next">&raquo;</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                        @endif
                    </ul>
                </div>
            @endif

        </div>
    </div>


    <style>
        .products-container {
            padding: 1.5rem;
            background-color: #f8f9fc;
        }

        .page-header {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            background: #f8f9fc;
            border-radius: 10px;
            padding: 0.5rem;
            border: 1px solid #e3e6f0;
        }

        .search-input {
            border: none;
            background: transparent;
            padding: 0.5rem;
            width: 250px;
            outline: none;
        }

        .search-button {
            background: #B1A05A;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-button:hover {
            background: #A89D4D;
        }

        .add-button {
            background: linear-gradient(45deg, #B1A05A, #A89D4D);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .add-button:hover {
            background: linear-gradient(45deg, #A89D4D, #8B7C3E);
            color: white;
            transform: translateY(-2px);
        }

        .table-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .products-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .products-table th {
            background: #f8f9fc;
            color: #B1A05A;
            padding: 1rem;
            font-weight: 600;
            text-align: left;
        }

        .product-row {
            transition: all 0.3s ease;
        }

        .product-row:hover {
            background: #f8f9fc;
            transform: translateX(5px);
        }

        .product-row td {
            padding: 1rem;
            vertical-align: middle;
        }

        .id-badge {
            background: #B1A05A;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .product-name {
            font-weight: 500;
        }

        .category-name {
            background: #e3e6f0;
            padding: 0.3rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        .image-container {
            width: 100px;
            height: 100px;
            overflow: hidden;
            border-radius: 10px;
            border: 2px solid #e3e6f0;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
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

        .edit-btn {
            background: #f6c23e;
        }

        .edit-btn:hover {
            background: #dfa821;
            color: white;
        }

        .delete-btn {
            background: #e74a3b;
        }

        .delete-btn:hover {
            background: #be3827;
            color: white;
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

        .pagination-container {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination li a,
        .pagination li span {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: #f8f9fc;
            color: #B1A05A;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination li.active span {
            background: #B1A05A;
            color: white;
        }

        .pagination li a:hover {
            background: #e3e6f0;
        }
    </style>


    <script>
        function confirmDelete(productId) {
            Swal.fire({
                title: 'هل أنت متأكد من حذف المنتج؟',
                text: "لا يمكن التراجع عن هذا الإجراء",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#858796',
                confirmButtonText: 'نعم، احذفه',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${productId}`).submit();
                }
            });
        }
    </script>

    <!-- Hidden Delete Forms -->
    @foreach ($product as $rs)
        <form id="delete-form-{{ $rs->product_id }}" action="{{ route('products.destroy', $rs->product_id) }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

@endsection
