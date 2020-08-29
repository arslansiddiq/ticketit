<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Template</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  {{-- <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
    }
    img {
      display: block;
      height: auto;
      max-width: 100%;
    }
    .heading-bold {
      font-weight: 600;
    }
    .email-template__content {
      margin: 50px auto;
      max-width: 650px;
    }
    .email-template__content {
      margin: 50px auto;
      max-width: 650px;
      box-shadow: -5px 1px 13px 7px rgba(0,0,0,0.05);
      border-top: 2px solid #14b6b7;
    }
    .email-template__header {
      padding: 50px;
      display: flex;
      align-items: center;
    }
    .email-template__logo {
      width: 220px;
      margin-right: 20px;
    }
    .email-template__navigation {
      display: flex;
      justify-content: flex-end;
      width: 310px;
    }
    .email-template__navigation ul {
      padding: 0;
      margin: 0;
      list-style: none;
    }
    .email-template__navigation ul li {
      display: inline-block;
      border-right: 1px solid #bebebe;
      padding: 0 5px;
    }
    .email-template__navigation ul li:last-child {
      border-right: 0 none;
    }
    .email-template__navigation ul li a {
      color: #bebebe;
      font-size: 14px;
      text-decoration: none;
      display: block;
      line-height: 15px;
      font-family: 'Montserrat', sans-serif;
    }
    .email-template__body {
      padding: 0 50px;
    }
    .email-template__intro {
      margin: 0 0 20px;
      font-weight: 400;
      font-size: 20px;
    }
    .email-template__message {
      line-height: 1.4em;
      font-size: 15px;
    }
    .email-template__schedule {
      margin: 50px auto;
      width: 100%;
    }
    .email-template__schedule td:first-child {
      padding: 5px 10px 5px 0;
      width: 70px;
    }
    .email-template__btn {
      display: table;
      margin: 0 auto;
      text-decoration: none;
      background-color: #14b6b7;
      color: #ffffff;
      padding: 18px 30px;
      border-radius: 5px;
      font-size: 20px;
    }
    .email-template__thank-you {
      text-align: center;
      font-weight: 500;
      font-size: 20px;
      margin-top: 50px;
      margin-bottom: 10px;
      color: #3f4040;
    }
    .email-template__reply {
      display: block;
      text-align: center;
      color: #909090;
      font-size: 12px;
    }
    .email-template__reply-link {
      display: table;
      margin: 0 auto;
      color: #098ebf;
      font-size: 14px;
    }
    .email-template__footer {
      background: transparent url("{{ asset('images/ticket-email/footer-bg.png') }}") no-repeat scroll -91px 0 / 850px auto;
      margin-top: 100px;
    }
    .email-template__footer-content {
      padding: 50px 50px 15px 50px;
      display: flex;
      align-items: center;
    }
    .email-template__footer-content {
      position: relative;
      top: -8px;
    }
    .email-template__footer-icon i {
      color: #ffffff;
      font-size: 32px;
      margin-right: 12px;
    }
    .email-template__footer-details {
      position: relative;
      top: 2px;
    }
    .email-template__footer-details h5 {
      margin: 0;
      color: #ffffff;
      font-size: 18px;
      font-weight: 400;
      line-height: 14px;
    }
    .email-template__footer-details a {
      text-decoration: none;
      color: #ffffff;
      font-size: 15px;
    }
  </style> --}}
</head>
<body style="font-family: 'Arial', sans-serif;margin: 0;">
  <div id="email-template-wrapper">
    <div class="email-template__content" style="margin: 50px auto;max-width: 650px;box-shadow: -5px 1px 13px 7px rgba(0,0,0,0.05);border-top: 2px solid #14b6b7;">
      <div class="email-template__header" style="padding: 50px;display: flex;align-items: center;">
        <div class="email-template__logo" style="width: 220px;margin-right: 20px;">
          <img src="https://app.leadgenerated.com/images/ticket-email/leadgenerated-logo.png" alt="" style="display: block;height: auto;max-width: 100%;">
        </div><!-- .email-template__logo -->
        <nav class="email-template__navigation" style="display: flex;justify-content: flex-end;width: 310px;">
          <ul style="padding: 0;margin: 0;list-style: none;">
            <li style="display: inline-block;border-right: 1px solid #bebebe;padding: 0 5px;"><a href="https://www.leadgenerated.com/" style="color: #bebebe;font-size: 14px;text-decoration: none;display: block;line-height: 15px;font-family: 'Montserrat', sans-serif;">Home</a></li>
            <li style="display: inline-block;border-right: 1px solid #bebebe;padding: 0 5px;"><a href="https://www.leadgenerated.com/contact/" style="color: #bebebe;font-size: 14px;text-decoration: none;display: block;line-height: 15px;font-family: 'Montserrat', sans-serif;">Contact</a></li>
            <li style="display: inline-block;border-right: 1px solid #bebebe;padding: 0 5px;"><a href="https://www.leadgenerated.com/support/" style="color: #bebebe;font-size: 14px;text-decoration: none;display: block;line-height: 15px;font-family: 'Montserrat', sans-serif;">Support</a></li>
            <li style="display: inline-block;border-right: 0 none;padding: 0 5px;"><a href="{{ url('/') }}" style="color: #bebebe;font-size: 14px;text-decoration: none;display: block;line-height: 15px;font-family: 'Montserrat', sans-serif;">Login</a></li>
          </ul>
        </nav>
      </div><!-- .email-template__header -->
      <div class="email-template__body" style="padding: 0 50px;">

        @yield('content')

        @yield('link')

        @yield('comment')

      </div>
      <!-- .email-template__body -->
      <div class="email-template__footer" style="background: transparent url('https://app.leadgenerated.com/images/ticket-email/footer-bg.png') no-repeat scroll -91px 0 / 850px auto; margin-top: 100px;">
        <div class="email-template__footer-content" style="padding: 50px 50px 15px 50px;display: flex;align-items: center;position: relative;top: -8px;">
          <div class="email-template__footer-icon">
            <i class="fa fa-envelope-open-o" aria-hidden="true" style="display: inline-block;font: normal normal normal 14px/1 FontAwesome;font-size: 32px;text-rendering: auto;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #ffffff;margin-right: 12px;"></i>
          </div><!-- .email-template__footer-icon -->
          <div class="email-template__footer-details" style="position: relative;top: 2px;">
            <h5 style="margin: 0;color: #ffffff;font-size: 18px;font-weight: 400;line-height: 14px;">Lead Generated:</h5>
            <a href="mailto:support@leadgenerated.com" style="text-decoration: none;color: #ffffff;font-size: 15px;">support@leadgenerated.com</a>
          </div>
        </div><!-- .email-template__footer-content -->
      </div><!-- .email-template__footer -->
    </div><!-- .email-template__content -->
  </div><!-- #email-template-wrapper -->
</body>
</html>