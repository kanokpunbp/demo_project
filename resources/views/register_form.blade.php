@extends('template.template_view')

@section('content')
    <section class="py-5">
        <div class="container px-5">
            <!-- Contact form-->
            <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i
                            class="bi bi-person-circle"></i></div>
                    <h1 class="fw-bolder">Register</h1>
                    <p class="lead fw-normal text-muted mb-0">Let's work together!</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">

                        <form enctype="multipart/form-data" name="frm_register" id="frm_register" autocomplete="off"
                            onsubmit="return onclick_save();" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control" id="fullname" name="fullname" type="text" />
                                <label for="name">Full name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="text" />
                                <label for="email">Email address</label>

                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="user_name" name="user_name" type="text" />
                                <label for="user_name">Username</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="password" name="password" type="password" />
                                <label for="password">Password</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="confirm_password" name="confirm_password" type="password" />
                                <label for="confirm_password">Confirm Password</label>
                            </div>

                            <div class="d-grid"><button class="btn btn-primary btn-lg" id="submitButton"
                                    type="submit">Submit</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function validation_data() {

            var checkiSerror = false; //ไม่มี error

            checkiSerror = validateField(checkiSerror, '#fullname',
                'Please Input fullname');
            checkiSerror = validateField(checkiSerror, '#email',
                'Please Input email');
            checkiSerror = validateField(checkiSerror, '#user_name',
                'Please Input username');
            checkiSerror = validateField(checkiSerror, '#password',
                'Please Input password');
            checkiSerror = validateField(checkiSerror, '#confirm_password',
                'Please Input confirm_password');

            var emailCheck = check_duplicate($("#email").val(), "email", "email", "#email");
            var usernameCheck = check_duplicate($("#user_name").val(), "user_name", "username", "#user_name");

            checkiSerror = checkiSerror || emailCheck || usernameCheck;

            if (checkiSerror == true) {
                $('.error').first().focus();
                $([document.documentElement, document.body]).animate({
                    scrollTop: parseInt($(".error").offset().top) - 150
                }, 1000);
                return false;
            } else {
                return true;
            }

        }

        function onclick_save() {
            
            if (validation_data() == true) {
                url = "{{ url('ajax_save_register') }}";
                form_ajax(url, "frm_register", 'post', function(data) {
                    if (data.status) {
                        alert_success("Register successfully");
                        setTimeout(function() {

                            window.location = "{{ url('/login') }}"
                        }, 1000);

                    } else {

                        $('#submitErrorMessage').html(data.msg);
                        return false;
                    }
                });
            }
            return false;
        }

        function check_duplicate(txt_check, field_name, txt_warning, ele_id) {
            if (txt_check != '') {
            url = "{{ url('check_duplicate') }}";
            var formData = {
                txt_check: txt_check,
                field_name: field_name,
                txt_warning: txt_warning,
            };
            form_ajax_customdata(url, formData, function(data) {

                var $field = $(ele_id);
                if (data.status == false) {

                    msg_err = data.msg;
                    $field.addClass('error');
                    $field.next('.text-danger').remove();
                            var txt_err = `<span class="text-danger">${msg_err}</span>`;
                          $field.after(txt_err);

                    return true;
                } else {
                    $field.removeClass('error');
                    $field.next('.text-danger').remove();
                    return false;
                }

            });
        }
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#email").on("change", function() {
                check_duplicate($("#email").val(), "email", "email", "#email");
            });

            $("#user_name").on("change", function() {
                check_duplicate($("#user_name").val(), "user_name", "username", "#user_name");
            });
        });
    </script>
@endsection
