<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xem lịch sử mua gói phim</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css"
        integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css"
        integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css'>



</head>
<style>
    .project-list-table {
        border-collapse: separate;
        border-spacing: 0 12px
    }

    .project-list-table tr {
        background-color: #fff
    }

    .table-nowrap td,
    .table-nowrap th {
        white-space: nowrap;
    }

    .table-borderless>:not(caption)>*>* {
        border-bottom-width: 0;
    }

    .table>:not(caption)>*>* {
        padding: 0.75rem 0.75rem;
        background-color: var(--bs-table-bg);
        border-bottom-width: 1px;
        box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    .me-2 {
        margin-right: 0.5rem !important;
    }

    a {
        color: #3b76e1;
        text-decoration: none;
    }

    .badge-soft-danger {
        color: #f56e6e !important;
        background-color: rgba(245, 110, 110, .1);
    }

    .badge-soft-success {
        color: #63ad6f !important;
        background-color: rgba(99, 173, 111, .1);
    }
    .badge-soft-warning {
        color: #ff7e05 !important;
        background-color: rgba(99, 173, 111, .1);
    }

    .badge-soft-primary {
        color: #3b76e1 !important;
        background-color: rgba(59, 118, 225, .1);
    }

    .badge-soft-info {
        color: #57c9eb !important;
        background-color: rgba(87, 201, 235, .1);
    }

    .bg-soft-primary {
        background-color: rgba(59, 118, 225, .25) !important;
    }

    body {
        margin-top: 20px;
        background-color: #eee;
    }
</style>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="mb-3">
                <h5 class="card-title"><a href="{{ route('homepage') }}">Trang chủ</a></h5>
            </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <h5 class="card-title">Danh sách mua gói và trạng thái gói<span
                            class="text-muted fw-normal ms-1">({{ count($list_order) }})</span></h5>
                </div>
            </div>
           
            
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="table-responsive">
                        <table class="table project-list-table table-nowrap align-middle table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col" class="ps-4" style="width: 50px;">
                                        <div class="form-check font-size-16"><input type="checkbox"
                                                class="form-check-input" id="contacusercheck" /><label
                                                class="form-check-label" for="contacusercheck"></label></div>
                                    </th>
                                    <th scope="col">#Mã đơn hàng</th>
                                    <th scope="col">Tên khách hàng</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Tên gói</th>
                                    <th scope="col">Giá gói</th>
                                    <th scope="col">Thời hạn của gói</th>
                                    <th scope="col">Ngày bắt đầu</th>
                                    <th scope="col">Ngày kết thúc</th>
                                    <th scope="col">Thanh toán</th>
                                    <th scope="col">Ngày đăng ký</th>
                                    <th scope="col">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_order as $order)
                                    <tr>
                                        <th scope="row" class="ps-4">
                                            <div class="form-check font-size-16"><input type="checkbox"
                                                    class="form-check-input" id="contacusercheck1" /><label
                                                    class="form-check-label" for="contacusercheck1"></label></div>
                                        </th>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->user->email }}</td>
                                        <td>{{ $order->package->title }}</td>
                                        <td>{{ number_format($order->price, 0, '', ',') }}</td>
                                        <td>{{ $order->number_date }} Ngày</td>
                                        <td> <span
                                                class="badge badge-soft-primary mb-1">{{ \Carbon\Carbon::createFromDate($order->date_start)->format('d-m-Y') }}</span>
                                        </td>
                                        <td><span
                                                class="badge badge-soft-warning mb-1">{{ \Carbon\Carbon::createFromDate($order->date_end)->format('d-m-Y') }}</span>
                                        </td>
                                        <td>{{ $order->payment }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            @if ($order->expiry == 0)
                                                <span class="badge badge-soft-success mb-0">Đang sử dụng</span>
                                            @else
                                                <span class="badge badge-soft-danger mb-0">Đã hết hạn sử dụng</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-0 align-items-center pb-4">
            <div class="col-sm-6">
                
            </div>
            <div class="col-sm-6">
                <div class="float-sm-end">
                    {{-- <ul class="pagination mb-sm-0">
                        <li class="page-item disabled">
                            <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">4</a></li>
                        <li class="page-item"><a href="#" class="page-link">5</a></li>
                        <li class="page-item">
                            <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                        </li>
                    </ul> --}}
                    {!! $list_order->links('vendor.pagination.custom1') !!}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
