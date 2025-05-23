<html lang="ar" dir="rtl">
@section('title','تعين كلمة مرور جديدة')
<link rel="stylesheet" href="{{ url('admin/assets/pages/css/login.min.css') }}">
@include('apps::dashboard.layouts._head_ltr')
<style>
    .help-block {
        color: red
    }
</style>
<body class="login">

@include('apps::dashboard.layouts._jquery')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>
<script>
    @if(session('success_alert'))
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: '{{session('success_alert')}}',
        showConfirmButton: true,
    });
    @endif

    @if(session('danger_alert'))
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: '{{session('danger_alert')}}',
        showConfirmButton: true
    });
    @endif
</script>
@stack('scripts')
</body>
</html>