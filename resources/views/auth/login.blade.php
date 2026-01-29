
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Accounting Login</title>
	
<link rel="shortcut icon" href="{{ asset('favicon.png') }}">

<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<link href="{{ asset('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') }}" rel="stylesheet">
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
 


<style>
    .brand-logo {
        width: 110px;
        height: auto;
        filter: drop-shadow(0px 2px 3px rgba(0,0,0,0.2));
    }
    .auth-card {
        width: 360px;
        border-radius: 16px;
    }
</style>

</head>

<body class="bg-light">

<div class="container-fluid vh-100">
    <div class="row">

        <div class="col-md-6 d-none d-md-flex 
            align-items-center justify-content-center text-white"
            style="background: linear-gradient(135deg, #0d6efd, #4c8dff); height: 100vh;">

            <div class="text-center px-5">
                
                <img src="{{ asset('assets/images/rosebakeshop_logo.png') }}" class="brand-logo mb-3" alt="Company Logo">

                <h1 class="fw-bold mt-2 mb-2">ACCOUNTING SYSTEM</h1>
                <p class="lead mb-0">Inventory - Sales - Reporting - Management</p>
            </div>
        </div>

        <div class="col-md-6 d-flex align-items-center justify-content-center" 
             style="height: 100vh;">

            <div class="card shadow-sm p-4 auth-card">

                <div class="text-center mb-3">
                    <img src="{{ asset('assets/images/jathnier_logo.png') }}" class="brand-logo mb-2" alt="Company Logo">

                    <h4 class="mb-1">Welcome Back</h4>
                    <p class="text-muted mb-3">Login to access your accounting dashboard</p>
                </div>





                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" id="username" class="form-control form-control-lg" placeholder="Enter username" autocomplete="off" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" class="form-control form-control-lg" placeholder="Enter password" autocomplete="off" required>
                        <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer;">
                            <i class="bi bi-eye-fill" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <button id="loginbtn" class="btn btn-primary btn-lg w-100 mt-2" onclick="loginsubmit()">Login</button>

				<div id="loginMsg" class="text-danger text-center mb-2"></div>
				
            </div>
        </div>

    </div>
</div>



<script>

function togglePassword() {
    const pass = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if(pass.type === 'password'){
        pass.type = 'text';
        icon.classList.replace('bi-eye-fill','bi-eye-slash-fill');
    } else {
        pass.type = 'password';
        icon.classList.replace('bi-eye-slash-fill','bi-eye-fill');
    }
}



function loginsubmit() {
    const username = $('#username').val().trim();
    const password = $('#password').val().trim();
    const msgEl = $('#loginMsg');

    if(!username || !password){
        msgEl.text('Please enter username and password');
        return;
    }

    $.ajax({
        url: '/login',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            username: username,
            password: password
        },
        dataType: 'json',
        success: function(res){
            if(res.status == 1){
                msgEl.html('<span style="color:green">'+res.msg+'</span>');
                setTimeout(function(){ window.location.href = '/'; }, 1000);
            } else {
                msgEl.html('<span style="color:red">'+res.msg+'</span>');
            }
        },
        error: function(){
            msgEl.html('<span style="color:red">Server error. Try again.</span>');
        }
    });
}



</script>



</body>
</html>
