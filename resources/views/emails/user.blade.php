<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supply Chain - Account Created</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0;">

  <div class="container mt-3" style="background:#ffffff; border-radius:12px; padding:20px;">

    <!-- Header -->
    <table style="width: 100%;">
      <tr>
        <td style="text-align: right; font-size: 12px;">
          Need help? <a href="#">Contact Us</a>
        </td>
      </tr>
    </table>

    <!-- Welcome Message -->
    <p><strong>Dear Supply Chain Partner,</strong></p>
    <p>
      We are pleased to confirm that your <b>Supply Chain account</b> has been successfully created.  
      Welcome to our platform 🚀
    </p>

    <!-- Login Credentials -->
    <p><strong>Your Login Credentials are as follows:</strong></p>
    <ul>
      <li>Email - {{ $user->email }}</li>
      <li>Login Portal - <a href="http://127.0.0.1:8000/login">Click Here</a></li>
    </ul>

    <!-- Terms -->
    <p>Please review the following terms:</p>
    <p><b>☛ Work Standards:</b> Ensure timely updates of supply records and maintain data accuracy.</p>
    <p><b>☛ Support:</b> If you face issues, please contact your assigned coordinator.</p>
    <p><b>☛ Payments:</b> Payments are processed monthly, based on verified supply data entries.</p>

    <p>
      If you do not agree with these terms, you are not permitted to use the Supply Chain system.  
      Otherwise, by logging in, you automatically agree to our terms of service.
    </p>

    <p>Thank you for joining <b>Supply Chain</b>. We look forward to working with you!</p>
    <p><strong>Best regards,<br>Supply Chain Team</strong></p>

    <hr>

    <p style="font-size: 10px; text-align: justify;">
      This is an auto-generated mail. Please do not reply to this email.  
      For queries, visit <a href="#">Supply Chain Support Portal</a>.
    </p>
    <p style="font-size: 10px; text-align: justify;">
      <b>Important:</b> Supply Chain never asks for your password, OTP, or banking details.  
      Please do not share confidential information with anyone.
    </p>

    <!-- Social -->
    <div style="text-align: center; margin-top: 10px;">
      <p>FOLLOW US ON SOCIAL MEDIA</p>
      <a href="#" target="_blank">Facebook</a> | 
      <a href="#" target="_blank">Twitter</a> | 
      <a href="#" target="_blank">LinkedIn</a>
    </div>

  </div>
</body>
</html>
