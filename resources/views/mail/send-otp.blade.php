<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifcation OTP</title>
    <style>
        div{
            width:600px;
            margin:auto;
        }
        h1{
            text-align: center;
            background-color: rgb(133, 182, 231);
            padding: 50px 0px;
        }
        .footer{
            padding:50px 0px;
            background-color: rgb(133, 182, 231);

        }
        b{
            color:dodgerblue
        }
    </style>
</head>
<body>
   <div>
    <h1>Otp Verification</h1>
    {{-- <p>Hi {{$userData->name}} !</p> --}}
    <p>Hi {{$userData->name}} !</p>
    <p>Your verifcation otp is <b>{{ $userData->otp}}</b> </p>
    <p>Your OTP will expire at {{$userData->expire_at}}</p>
    <p class="footer"></p>

   </div>
</body>
</html>