@php
    use Carbon\Carbon;

    $settings = settings();
    $expDate = Carbon::parse($settings['expiry_date']);
    
    $today = Carbon::now();
    $expired = $expDate->lessThan($today);

@endphp


<!DOCTYPE html>

<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

<!-- begin::Head -->
<head>
    <link rel="stylesheet" type="text/css" href="../../sass/app.scss"/>
    <meta charset="utf-8"/>
    <title>Document Management System | Login</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--end::Web font -->

    <!--begin::Global Theme Styles -->
    <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css"/>

    <!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>

    <!--RTL version:<link href="../../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

    <!--end::Global Theme Styles -->
    <link rel="shortcut icon" href="{{ asset('favicon_.ico') }}"/>
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <!-- <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1"
             id="m_login" style="background-image: url('{{ asset('assets/app/media/img//bg/bg-3.jpg') }}');"> -->
             {{-- <div style="background: rgb(180,115,58);background: linear-gradient(90deg, rgba(180,115,58,1) 0%, rgba(219,81,38,1) 44%, rgba(252,176,69,1) 100%);" class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1 gradient-bg"
             id="m_login"> --}}
             <div style="background: rgb(241,167,85);background: linear-gradient(90deg, rgba(241,167,85,1) 0%, rgba(236,154,75,1) 48%, rgba(223,132,38,1) 100%);" class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1 gradient-bg"
             id="m_login">
            <div  class="m-grid__item m-grid__item--fluid m-login__wrapper">
                <div class="m-login__container login_banner">
                    {{--<div class="m-login__logo">--}}
                    {{--<a href="#">--}}
                    {{--<img src="{{ asset( 'storage/'.$settings['logo'] ) }}" alt="Logo">--}}
                    {{--</a>--}}
                    {{--</div>--}}

                    <div class="login-form-banner text-center">
                        <img src="{{ asset( 'storage/'.$settings['logo'] ) }}" alt="Logo">
                    </div>
                    
                    @if($expired)    
                    <div class="m-alert m-alert--icon alert alert-warning" role="alert">
                            <div class="m-alert__icon">
                                <i class="la la-warning"></i>
                            </div>
                            <div class="m-alert__text">
                                <strong>
                                    Your access and subscription to MaxFiles has expired. Please contact DataMax Admin for renewal.
                                </strong>
                            </div>
                            {{-- <div class="m-alert__close">
                                <button type="button" class="close" data-close="alert" aria-label="Hide">
                                </button>
                            </div> --}}
                        </div>

                    @endif    

                    <div class="m-login__signin">
                        {{--<div class="m-login__head">--}}
                        {{--<h3 class="font-weight-bold">--}}
                        {{--MaxFiles--}}
                        {{--</h3>--}}
                        
                        {{--</div>--}}

                        <div class="info-text">
                            Input your login details
                        </div>

                        <form class="m-login__form m-form" action="{{ route('login') }}" method="post">
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text"  placeholder="Email/ Staff ID" name="email" {{ ($expired)?'disabled="true"':'' }} 
                                       autocomplete="off">
                            </div>
                            
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last" id="myInput" type="password" {{ ($expired)?'disabled="true"':'' }}  
                                       placeholder="Password" name="password">
                            </div>
                            <div class="row m-login__form-sub m--hide">
                                <div class="col m--align-left m-login__form-left">
                                    <label class="m-checkbox  m-checkbox--light">
                                        <input type="checkbox" name="remember"> Remember me
                                        <span></span>
                                    </label>
                                </div>
                                <!-- <div class="col m--align-right m-login__form-right">
                                    <a href="javascript:;" id="m_login_forget_password" class="m-link">Forget Password ?</a>
                                </div> -->
                            </div>

                            @if(!$expired)
                            <div class="m-login__form-action">
                                <!-- <button id="m_login_signin_submit"
                                        class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                    Sign In
                                </button> -->
                                <button type="submit" id="m_login_signin_submit" class=" m-btn m-btn--pill btn btn-warning btn-lg text-light" >Sign In</button>
                            </div>
                            @endif

                            <div class="login-form-footer">
                                <img src="{{ asset('img/maxfiles1.png') }}" alt="Logo"> 
                            </div>
                            @csrf
                        </form>
                    </div>


                    <div class="m-login__signup">
                        <div class="m-login__head">
                            <h3 class="m-login__title">Sign Up</h3>
                            <div class="m-login__desc">Enter your details to create your account:</div>
                        </div>
                        <form class="m-login__form m-form" action="{{ route('register') }}" method="post">
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="First name"
                                       name="first_name">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Last name"
                                       name="last_name">
                            </div>

                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Username" name="username">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Staff Id" name="staff_id">
                            </div>
                            @csrf
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Email" name="email"
                                       autocomplete="off">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="password" id="password" placeholder="Password"
                                       name="password">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last" type="password"
                                       placeholder="Confirm Password" name="rpassword">
                            </div>
                            <div class="row form-group m-form__group m-login__form-sub">
                                <div class="col m--align-left">
                                    <label class="m-checkbox m-checkbox--light">
                                        <input type="checkbox" name="agree">I Agree the <a href="#"
                                                                                           class="m-link m-link--focus">terms
                                            and conditions</a>.
                                        <span></span>
                                    </label>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="m-login__form-action">
                                <button id="m_login_signup_submit"
                                        class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                    Sign Up
                                </button>&nbsp;&nbsp;
                                <button id="m_login_signup_cancel"
                                        class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="m-login__forget-password">
                        <div class="m-login__head">
                            <h3 class="m-login__title">Forgotten Password ?</h3>
                            <div class="m-login__desc">Enter your email to reset your password:</div>
                        </div>
                        <form class="m-login__form m-form" action="">
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Email" name="email"
                                       id="m_email" autocomplete="off">
                            </div>
                            <div class="m-login__form-action">
                                <button id="m_login_forget_password_submit"
                                        class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                    Request
                                </button>&nbsp;&nbsp;
                                <button id="m_login_forget_password_cancel"
                                        class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- 	<div class="m-login__account">
                            <span class="m-login__account-msg">
                                Don't have an account yet ?
                            </span>&nbsp;&nbsp;
                            <a href="javascript:;" id="m_login_signup" class="m-link m-link--light m-login__account-link">Sign Up</a>
                        </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Page -->

    <!--begin::Global Theme Bundle -->
    <script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>

    <!--end::Global Theme Bundle -->

    <!--begin::Page Scripts -->
    <script src="{{ asset('assets/snippets/custom/pages/user/login.js') }}" type="text/javascript"></script>

    <!--end::Page Scripts -->

    <script type="text/javascript">
        // var input = document.getElementById("myInput");
        //     input.addEventListener("keyup", function(event) {
        //     if (event.keyCode === 13) {
        //     event.preventDefault();
        //     document.getElementById("m_login_signin_submit").click();
        //     }
        //     });

        var SnippetLogin = function () {
            var e = $("#m_login"),
                i = function (e, i, a) {
                    var l = $('<div class="m-alert m-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
                    e.find(".alert").remove(), l.prependTo(e), mUtil.animateClass(l[0], "fadeIn animated"), l.find("span").html(a)
                },
                a = function () {
                    e.removeClass("m-login--forget-password"), e.removeClass("m-login--signup"), e.addClass("m-login--signin"), mUtil.animateClass(e.find(".m-login__signin")[0], "flipInX animated")
                },
                l = function () {
                    $("#m_login_forget_password").click(function (i) {
                        i.preventDefault(), e.removeClass("m-login--signin"), e.removeClass("m-login--signup"), e.addClass("m-login--forget-password"), mUtil.animateClass(e.find(".m-login__forget-password")[0], "flipInX animated")
                    }), $("#m_login_forget_password_cancel").click(function (e) {
                        e.preventDefault(), a()
                    }), $("#m_login_signup").click(function (i) {
                        i.preventDefault(), e.removeClass("m-login--forget-password"), e.removeClass("m-login--signin"), e.addClass("m-login--signup"), mUtil.animateClass(e.find(".m-login__signup")[0], "flipInX animated")
                    }), $("#m_login_signup_cancel").click(function (e) {
                        e.preventDefault(), a()
                    })
                };
            return {
                init: function () {
                    l(), $("#m_login_signin_submit").click(function (e) {
                        e.preventDefault();
                        var a = $(this),
                            l = $(this).closest("form");
                        l.validate({
                            rules: {
                                email:    {
                                    required: !0,
                                    
                                },
                                password: {
                                    required: !0
                                }
                            }
                        }), l.valid() && (a.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), l.ajaxSubmit({
                            url:     "{{ route('login') }}",
                            success: function (e, t, r, s) {
                                console.log(e)

                                if (e.status == 500 || e.status == 400 || e.status == 404) {
                                    setTimeout(function () {
                                        a.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), i(l, "danger", e.message);
                                    }, 2e3);
                                }
                                 else {
                                    // Redirect to Login Page
                                    console.log('logged In');
                                    document.location = "{{ route('dashboard') }}";
                                }
                            }
                        }))
                    }),
                        $("#m_login_signup_submit").click(function (l) {
                            l.preventDefault();
                            var t = $(this),
                                r = $(this).closest("form");
                            r.validate({
                                rules: {
                                    first_name: {
                                        required: !0
                                    },
                                    last_name:  {
                                        required: !0
                                    },
                                    staff_id:   {
                                        required: !0
                                    },
                                    username:   {
                                        required: !0
                                    },
                                    email:      {
                                        required: !0,
                                        email:    !0
                                    },
                                    password:   {
                                        required: !0
                                    },
                                    rpassword:  {
                                        required: !0,
                                        equalTo:  "#password"
                                    },
                                    agree:      {
                                        required: !0
                                    }
                                }
                            }), r.valid() && (t.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), r.ajaxSubmit({
                                url:     "{{ route('register') }}",
                                success: function (l, s, n, o) {

                                    if (l.status == 200) {

                                        t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), r.clearForm(), r.validate().resetForm(), a();
                                        var l = e.find(".m-login__signin form");
                                        l.clearForm(), l.validate().resetForm(), i(l, "success", "Thank you. To complete your registration please check your email.")

                                        setTimeout(function () {
                                            document.location = "{{ route('loggedIn') }}";
                                        }, 2e3)
                                    }


                                }
                            }))
                        }), $("#m_login_forget_password_submit").click(function (l) {
                        l.preventDefault();
                        var t = $(this),
                            r = $(this).closest("form");
                        r.validate({
                            rules: {
                                email: {
                                    required: !0,
                                    email:    !0
                                }
                            }
                        }), r.valid() && (t.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), r.ajaxSubmit({
                            url:     "{{ route('register') }}",
                            success: function (l, s, n, o) {
                                setTimeout(function () {
                                    t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), r.clearForm(), r.validate().resetForm(), a();
                                    var l = e.find(".m-login__signin form");
                                    l.clearForm(), l.validate().resetForm(), i(l, "success", "Cool! Password recovery instruction has been sent to your email.")
                                }, 2e3)
                            }
                        }))
                    })
                }
            }
        }();
        jQuery(document).ready(function () {
            SnippetLogin.init()
        });
    </script>
</body>

<!-- end::Body -->
</html>
