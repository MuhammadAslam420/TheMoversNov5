<!DOCTYPE html>
<html>
<head>
  <title>Mobile OTP Validation</title>
  <style>
    body {
      background-image: url('background-image.jpg');
      background-size: cover;
      background-position: center;
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 5px;
      margin-top: 100px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 10px;
    }

    input[type="text"], input[type="number"], input[type="password"] {
      width: 100%;
      padding: 10px;
      border-radius: 3px;
      border: 1px solid #ccc;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: #fff;
      text-decoration: none;
      border-radius: 3px;
      margin-top: 10px;
    }

    .btn:hover {
      background-color: #45a049;
    }

    .otp-field {
      display: none;
    }

    .flag-icon {
      display: inline-block;
      width: 20px;
      height: 15px;
      margin-right: 5px;
    }

    .error {
      color: red;
      margin-top: 5px;
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
</head>
<body>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <div class="container">
    <h2>Mobile OTP Validation</h2>
    <form id="otp_form">
      @csrf
      <label for="country">Country:</label>
      <select id="dial_code" name="dial_code" required>
        <option value="">Select Country</option>
        @foreach($countries as $country)
        <option value="{{ $country->dial_code }}">{{ $country->dial_code }}</option>
        @endforeach
      </select>

      <label for="mobile">Mobile Number:</label>
      <input type="number" id="mobile" name="mobile" placeholder="Enter Mobile Number" required>
      <div id="recaptcha-container"></div> <!-- Recaptcha container -->

      <button type="submit" class="btn" id="send_otp_btn" onclick="sendOTP()">Send OTP</button>
      
      <div id="otpSection" class="otp-field">
        <label for="otp">OTP:</label>
        <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
        <button type="button" class="btn" id="validate_otp_btn">Validate OTP</button>
        <div id="otp_error" class="error"></div>
        <div id="otp_success" class="success"></div>    
      </div>
    </form>
  </div>

  <script src="{{ url('assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ url('assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-auth.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#dial_code').select2();
    });

    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "{{get_settings('firebase-api-key')}}",
        authDomain: "{{get_settings('firebase-auth-domain')}}",
        databaseURL: "{{get_settings('firebase-db-url')}}",
        projectId: "{{get_settings('firebase-project-id')}}",
        storageBucket: "{{get_settings('firebase-storage-bucket')}}",
        messagingSenderId: "{{get_settings('firebase-messaging-sender-id')}}",
        appId: "{{get_settings('firebase-app-id')}}",
        measurementId: "{{get_settings('firebase-measurement-id')}}"
      };

    // Initialize Firebase
   firebase.initializeApp(firebaseConfig);
    var auth = firebase.auth();

    var phoneAuthProvider = firebase.auth.PhoneAuthProvider;

    var confirmationResult = null;
    var recaptchaVerifier = null;

    function sendOTP() {
      var dialCode = document.getElementById('dial_code').value;
      var mobileNumber = document.getElementById('mobile').value;
      var phoneNumber = '+' + dialCode + mobileNumber;

      recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
      
      auth.signInWithPhoneNumber(phoneNumber, recaptchaVerifier)
        .then(function(result) {
          confirmationResult = result;
          showOtpField();
        })
        .catch(function(error) {
          console.error('OTP sending failed:', error);
        });
    }

    function showOtpField() {
      document.getElementById('send_otp_btn').style.display = 'none';
      document.getElementById('otpSection').style.display = 'block';
    }

function validateOTP() {
    var enteredOTP = document.getElementById('otp').value;

    confirmationResult.confirm(enteredOTP)
      .then(function(result) {
        var user = result.user;
        console.log('User signed in:', user);
        document.getElementById('otp_success').textContent = 'OTP verified successfully!';
        document.getElementById('otp_error').textContent = '';

        // Get the mobile number
        var dialCode = document.getElementById('dial_code').value;
        var mobileNumber = document.getElementById('mobile').value;
        var phoneNumber =  dialCode + mobileNumber;
        var url = "<?php echo url('ride/user-veification');?>";
        var csrfToken = '{{ csrf_token() }}'; // Set the CSRF token manually


        // Send the mobile number to the server via AJAX
        $.ajax({
          type: 'POST',
          url: url,
          headers: {
          'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
          },
          data: { mobileNumber: mobileNumber },
          success: function(response) {
            // console.log(response);
            if (response == true) {
              // Redirect to the dashboard view
              window.location.href = "<?php echo url('dashboard');?>";
            } else {
              // Create sign-in page with name, mobile, and email inputs
              // createSignInPage(mobileNumber);
              window.location.href = "<?php echo url('/sign-up');?>";

            }     
          },
          error: function(error) {
            console.error('Error sending mobile number to the server:', error);
          }
        });
      })
      .catch(function(error) {
        console.error('OTP verification failed:', error);
        document.getElementById('otp_success').textContent = '';
        document.getElementById('otp_error').textContent = 'Invalid OTP';
      });
  }

    document.getElementById('otp_form').addEventListener('submit', function(event) {
      event.preventDefault();
      sendOTP();
    });

    document.getElementById('validate_otp_btn').addEventListener('click', function(event) {
      event.preventDefault();
      validateOTP();
    });

  </script>
</body>
</html>
