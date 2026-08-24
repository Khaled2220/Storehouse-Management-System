<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>



<style>
body {
  background-color: #f4f6f9;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: system-ui, -apple-system, sans-serif;

}  

login-box {
  background-color: #ffffff;
  padding: 40px;
  border-radius: 6px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  width: 100%;
  max-width: 440px;
}

text-logo {
  font-size: 2.2rem;
  font-weight: 700;
  color: #0b4d7a;
    letter-spacing: -1px;
}

form-label {
  color: #4a5568;
  font-weight: 500;
  font-size: 0.9rem;
  margin-bottom: 6px;
}

form-control {
  border: 1px solid #cbd5e1;
  padding: 10px 14px;
  border-radius: 6px;
}

form-control:focus {
  border-color: #0b4d7a;
  box-shadow: 0 0 0 2px rgba(11, 77, 122, 0.15);
}

form-check-input {
  border: 2px solid #94a3b8;
  border-radius: 4px;
  width: 18px;
  height: 18px;
  cursor: pointer;
}

form-check-label {
  color: #475569;
  font-size: 0.95rem;
  padding-left: 4px;
  cursor: pointer;
}
forgot-link {
  color: #1a5680;
  text-decoration: none;
  font-size: 0.95rem;
  font-weight: 500;
  display: inline-block;
}

forgot-link:hover {
  text-decoration: underline;
}

btn-login {
  background-color: #0b4d7a;
   color: #ffffff;
  font-weight: 500;
  padding: 11px;
  border-radius: 6px;
  border: none;
  font-size: 1rem;
}
btn-login:hover {
  background-color: #083b5e;
  color: #ffffff;
}
</style>


<div class="container d-flex justify-content-center">
   <div class="card">
        <div class="card-body">
     <form method="POST" action="{{ url('/login') }}">
        @csrf
    <h2 class="text-center mb-4 text-logo">Login</h2><br>  
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" class="form-control" id="email" name="email">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="form-check d-flex align-items-center mb-3">
        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
        <label class="form-check-label ms-2" for="rememberMe">
            Remember me
        </label>
    </div>

   <button type="submit" 
        class="btn btn-block text-white fw-bold shadow-sm" 
        style="background-color: Navy; padding: 10px;">
    Login
</button>
    <p class="text-center mt-3 mb-0">
        <span class="text-muted small">Don't have an account?</span>

        <a href="{{ url('/register') }}"
           class="btn btn-sm text-white fw-bold ms-1 px-3 shadow-sm"
           style="background-color: Navy;">
           Create Account
        </a>
    </p>



</form>
</div>

