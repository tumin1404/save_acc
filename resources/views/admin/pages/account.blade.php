@extends('admin.layout')
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<h1 class="text-center my-4">QUẢN LÝ TÀI KHOẢN</h1>
<button type="button" class="btn mb-2 btn-outline-primary" data-toggle="modal" data-target=".bd-example-modal-lg">
    <span class="fe fe-plus fe-16 mr-2"></span>Thêm mới
</button>
<div class="row">
    <div class="col-md-12 my-4">
      <div class="card shadow">
        <div class="card-body">
          <div class="toolbar">
            <form class="form">
              <div class="form-row">
                <div class="form-group col-3 mr-auto">
                  <label for="search" class="sr-only">Search</label>
                  <input type="text" class="form-control" id="search1" value="" placeholder="Search">
                </div>
              </div>
            </form>
          </div>
          <!-- table -->
          <table class="table table-hover table-bordered border-v">
            <thead class="thead-dark">
              <tr>
                <th>Xem</th>
                <th>STT</th>
                <th>Tên đăng nhập</th>
                {{-- <th>Mật khẩu</th> --}}
                <th>Tên hiển thị</th>
                <th>Website/App</th>
                <th>Phone/Email Verify</th>
                {{-- <th>App/phone Authen</th>
                <th>2FA</th> --}}
                {{-- <th>Ngày thêm</th>
                <th>Ngày sửa</th> --}}
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach($accounts as $key => $account)
                    <tr>
                      <td><a href="#" class="btn btn-sm btn-primary btn-view"
                        data-toggle="modal" data-target=".modal-view-lg" data-id="{{ $account->id }}">Xem</a></td>
                        <td>{{ $key + 1 }}</td> {{-- Hiển thị STT --}}
                        <td>{{ $account->username }}</td>
                        {{-- <td>{{ $account->password }}</td> Chú ý: Không nên hiển thị password trực tiếp --}}
                        <td>{{ $account->account_name }}</td>
                        <td>{{ $account->website_app }}</td>
                        <td>{{ $account->phone_email_verify }}</td>
                        {{-- <td>{{ $account->app_phone_authen }}</td>
                        <td>{{ $account->{'2FA'} }}</td> --}}
                        {{-- <td>{{ $account->created_at }}</td>
                        <td>{{ $account->updated_at }}</td> --}}
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Sửa</a>
                            <form action="" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger btn-delete-account"
                                data-id="{{ $account->id }}">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            @if ($accounts->isEmpty())
                <tr><td colspan="11">Không có dữ liệu.</td></tr>
            @endif
            </tbody>
          </table>
          <nav aria-label="Table Paging" class="mb-0 text-muted">
            <ul class="pagination justify-content-center mb-0">
              <li class="page-item"><a class="page-link" href="#">Previous</a></li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
</div> <!-- end section -->

<!-- Modal thêm mới -->
<div class="modal fade bd-example-modal-lg" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="defaultModalLabel">Thêm mới tài khoản</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="AddAccountForm" action="{{ route('admin.account.store') }}" method="POST" onsubmit="submitForm(event)">
            @csrf  {{-- Thêm CSRF token --}}
          <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Tên hiển thị</label>
                    <input type="text" name="account_name" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Phone/Email Verify</label>
                    <input type="text" name="phone_email_verify" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>2FA</label>
                    <input type="text" name="2FA" class="form-control">
                  </div>
                </div> <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mật khẩu</label>
                        <input type="text" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Website/App</label>
                        <input type="text" name="website_app" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>App/phone Authen</label>
                        <input type="text" name="app_phone_authen" class="form-control">
                    </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <div class="mx-auto">
              <button type="submit" class="btn btn-outline-primary">Lưu</button>
              <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Thoát</button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>

<!-- Modal xem chi tiết -->
<div class="modal fade modal-view-lg" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="defaultModalLabel">Chi tiết tài khoản</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="ViewAccountForm">
        @csrf  
        <div class="modal-body">
          <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>ID</label>
                  <input type="text" id="id" name="id" class="form-control" readonly>
                </div>
                <div class="form-group">
                  <label>Tên đăng nhập</label>
                  <input type="text" id="username" class="form-control" readonly>
                </div>
                <div class="form-group">
                  <label>Tên hiển thị</label>
                  <input type="text" id="account_name" class="form-control" readonly>
                </div>
                <div class="form-group">
                  <label>Phone/Email Verify</label>
                  <input type="text" id="phone_email_verify" class="form-control" readonly>
                </div>
                <div class="form-group">
                  <label>Ngày nhập</label>
                  <input type="text" id="created_at" class="form-control" readonly>
                </div>
              </div> 
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Mật khẩu</label>
                      <input type="text" id="password" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                      <label>Website/App</label>
                      <input type="text" id="website_app" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                      <label>App/phone Authen</label>
                      <input type="text" id="app_phone_authen" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                    <label>2FA</label>
                    <input type="text" id="2FA" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                    <label>Ngày chỉnh sửa</label>
                    <input type="text" id="updated_at" class="form-control" readonly>
                  </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <div class="mx-auto">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Thoát</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
function submitForm(event) {
    event.preventDefault(); // Ngăn chặn form submit mặc định

    const form = document.getElementById('AddAccountForm');
    const formData = new FormData(form);

    fetch(form.action, {
        method: form.method,
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest', // Để Laravel biết đây là AJAX request
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Lỗi khi gửi request!');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message);
            $('#defaultModal').modal('hide');
            form.reset();
            loadAccounts(); // Cập nhật lại bảng
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã có lỗi xảy ra!');
    });
}

</script>
<script>
  function loadAccounts() {
    fetch('/admin/account/data') // Route để lấy dữ liệu account
    .then(response => response.json())
    .then(data => {
        const tableBody = document.querySelector('#accountTable tbody'); // Chọn tbody của bảng
        tableBody.innerHTML = ''; // Xóa dữ liệu cũ

        data.forEach(account => { // Duyệt qua dữ liệu mới và tạo các hàng của bảng
            const row = tableBody.insertRow();
            row.insertCell().textContent = account.id;
            row.insertCell().textContent = account.username;
            row.insertCell().textContent = account.password;
            row.insertCell().textContent = account.account_name;
            row.insertCell().textContent = account.website_app;
            row.insertCell().textContent = account.phone_email_verify;
            row.insertCell().textContent = account.app_phone_authen;
            row.insertCell().textContent = account.2FA;

            // Thêm nút sửa và xóa (nếu cần)
            const actionsCell = row.insertCell();
            actionsCell.innerHTML = `
                <a href="#" class="btn btn-sm btn-primary">Sửa</a>
                <form action="" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                </form>
            `;
        });
    });
}

// Gọi hàm loadAccount khi trang web được tải
window.onload = loadAccounts;
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Bắt sự kiện khi nhấn vào nút "Xem"
        document.querySelectorAll(".btn-view").forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
                
                let accountId = this.getAttribute("data-id"); // Lấy ID từ data-id
                console.log("ID tài khoản:", accountId); // Log để kiểm tra
                
                // Nếu muốn gửi request để lấy dữ liệu tài khoản:
                fetch(`/admin/account/${accountId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Dữ liệu tài khoản:", data); // Log toàn bộ dữ liệu
                        // Hiển thị dữ liệu lên modal
                        document.querySelector("input[name='id']").value = data.id;
                        document.querySelector("input[id='username']").value = data.username;
                        document.querySelector("input[id='account_name']").value = data.account_name;
                        document.querySelector("input[id='password']").value = data.password;
                        document.querySelector("input[id='website_app']").value = data.website_app;
                        document.querySelector("input[id='phone_email_verify']").value = data.phone_email_verify;
                        document.querySelector("input[id='app_phone_authen']").value = data.app_phone_authen;
                        document.querySelector("input[id='2FA']").value = data['2FA'];
                        document.querySelector("input[id='created_at']").value = data.created_at;
                        document.querySelector("input[id='updated_at']").value = data.updated_at;
                    })
                    .catch(error => console.error("Lỗi khi lấy dữ liệu tài khoản:", error));
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".btn-delete-account").forEach(button => {
            button.addEventListener("click", function() {
                let accountId = this.getAttribute("data-id"); // Lấy ID tài khoản
                console.log("ID tài khoản cần xóa:", accountId); // Log để kiểm tra

                if (confirm("Bạn có chắc chắn muốn xóa tài khoản này?")) {
                    fetch(`/admin/account/${accountId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Phản hồi từ server:", data); // Log phản hồi từ server

                        if (data.success) {
                            alert("Tài khoản đã được xóa thành công!");
                            location.reload(); // Reload lại trang để cập nhật danh sách
                        } else {
                            alert("Lỗi khi xóa tài khoản!");
                        }
                    })
                    .catch(error => console.error("Lỗi khi gửi yêu cầu xóa:", error));
                }
            });
        });
    });
</script>

@endsection