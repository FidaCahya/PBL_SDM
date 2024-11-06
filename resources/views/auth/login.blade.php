<html>
 <head>
  <title>
   Sistem Informasi Sumber Daya Manusia
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <style>
   body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Inter', bold;
            background: url('{{ asset('assets/background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }
        .container {
            text-align: center;
        }
        .header {
            margin-bottom: 50px;
        }
        .header img {
            height: 80px;
            vertical-align: middle;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .header h2 {
            font-size: 18px;
            margin: 0;
        }
        .login-box {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            text-align: left;
        }
        .login-box h3 {
            margin: 0 0 20px 0;
            font-size: 16px;
        }
        .login-box label {
            display: block;
            margin-bottom: 5px;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
        }
        .login-box input[type="checkbox"] {
            margin-right: 5px;
        }
        .login-box .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .login-box .options a {
            color: white;
            text-decoration: none;
        }
        .login-box .login-button {
            width: 100%;
            padding: 10px;
            background-color: #f1c40f;
            border: none;
            border-radius: 5px;
            color: black;
            font-weight: bold;
            cursor: pointer;
        }
  </style>
 </head>
 <body>
  <div class="container">
   <div class="header">
     <h1>
     SISTEM INFORMASI SUMBER DAYA MANUSIA
    </h1>
    <h2>
     JURUSAN TEKNOLOGI INFORMASI
    </h2>
   </div>
   <div class="login-box">
    <h3>
     Selamat Datang, Silahkan masukkan akun Anda.
    </h3>
    <label for="username">
     Username
    </label>
    <input id="username" name="username" type="text"/>
    <label for="password">
     Password
    </label>
    <input id="password" name="password" type="password"/>
    <div class="options">
     <div>
      <input id="show-password" type="checkbox"/>
      <label for="show-password">
       Tampilkan Password
      </label>
     </div>
     <a href="#">
      Lupa Password?
     </a>
    </div>
    <button class="login-button">
     LOGIN
    </button>
   </div>
  </div>
 </body>
</html>
