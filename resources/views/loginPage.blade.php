<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindEase — Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- Keep your original CSS unchanged --- */
        :root {
            --primary: #1a3c5e;
            --secondary: #2a5c8a;
            --accent: #4a90e2;
            --accent-light: #6bb3ff;
            --accent-dark: #1e5f99;
            --text: #e6f0f7;
            --text-muted: #b8d0e0;
            --card-bg: rgba(255, 255, 255, 0.1);
            --glass: rgba(255, 255, 255, 0.15);
            --radius: 12px;
            --transition: all 0.3s ease;
        }
        /* --- Rest of your original CSS --- */
        * { box-sizing: border-box; margin:0; padding:0;}
        body { font-family:'Inter', system-ui, sans-serif; background: linear-gradient(135deg, #1a3c5e 0%, #2a5c8a 50%, #1a3c5e 100%); color:var(--text); line-height:1.5; height:100vh; overflow:hidden; display:flex; align-items:center; justify-content:center;}
        .container {width:100%; height:100%; display:flex; align-items:center; justify-content:center; padding:20px;}
        .login-container {display:grid; grid-template-columns:1fr 1fr; width:100%; max-width:1200px; height:90vh; max-height:800px; background:var(--card-bg); border-radius:var(--radius); overflow:hidden; box-shadow:0 20px 40px rgba(0,0,0,0.4); border:1px solid rgba(255,255,255,0.1); backdrop-filter:blur(10px);}
        .login-image {height:100%; overflow:hidden; position:relative;}
        .login-image img {width:100%; height:100%; object-fit:cover; display:block; filter:brightness(0.9);}
        .image-overlay {position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent, rgba(0,0,0,0.7)); padding:30px; color:white;}
        .image-overlay h3 {font-size:22px; margin-bottom:10px;}
        .image-overlay p {font-size:14px; opacity:0.9;}
        .login-form {padding:40px; display:flex; flex-direction:column; height:100%; position:relative; overflow-y:auto;}
        .form-content {flex:1; display:flex; flex-direction:column; justify-content:center;}
        .back-home {position:fixed; top:30px; right:30px; font-size:18px; color:var(--text-muted); text-decoration:none; transition:var(--transition); background:rgba(255,255,255,0.1); width:45px; height:45px; border-radius:50%; display:flex; align-items:center; justify-content:center; z-index:100; backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,0.2);}
        .back-home:hover {color:white; background:rgba(255,255,255,0.2); transform:translateY(-2px);}
        .brand {display:flex; align-items:center; gap:15px; margin-bottom:40px;}
        .logo {width:55px; height:55px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:22px; color:white; background:linear-gradient(135deg,var(--accent), var(--accent-light)); box-shadow:0 6px 20px rgba(74,144,226,0.4);}        
        .logo-img {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            object-fit: contain;
            padding: 5px;
            background: transparent;
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }
        .brand-text h1 {margin:0; font-size:26px; background:linear-gradient(to right,#ffffff, var(--accent-light)); -webkit-background-clip:text; background-clip:text; color:transparent;}
        .brand-text p {margin:0; font-size:13px; color:var(--text-muted);}
        .login-header {margin-bottom:40px;}
        .login-header h2 {font-size:28px; margin-bottom:10px; color:white;}
        .login-header p {color:var(--text-muted); font-size:15px;}
        .form-group {margin-bottom:25px;}
        .form-group label {display:block; margin-bottom:8px; font-weight:500; color:var(--text); font-size:14px;}
        .input-with-icon {position:relative;}
        .input-with-icon i {position:absolute; left:15px; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:16px;}
        .form-control {width:100%; padding:14px 15px 14px 45px; border-radius:8px; border:1px solid rgba(255,255,255,0.2); background:rgba(255,255,255,0.1); color:var(--text); font-size:15px; transition:var(--transition); backdrop-filter:blur(5px);}
        .form-control:focus {outline:none; border-color:var(--accent); box-shadow:0 0 0 2px rgba(74,144,226,0.2); background:rgba(255,255,255,0.15);}
        .form-control::placeholder {color:var(--text-muted);}
        .btn {padding:14px 20px; border-radius:8px; border:none; font-weight:600; cursor:pointer; transition:var(--transition); font-size:15px; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; width:100%;}
        .btn-primary {background:linear-gradient(90deg,var(--accent), var(--accent-light)); color:white; box-shadow:0 4px 15px rgba(74,144,226,0.4); margin-top:10px;}
        .btn-primary:hover {transform:translateY(-2px); box-shadow:0 6px 20px rgba(74,144,226,0.6);}
        .login-options {display:flex; justify-content:space-between; align-items:center; margin-top:20px; font-size:14px;}
        .remember-me {display:flex; align-items:center; gap:8px;}
        .remember-me input {accent-color:var(--accent); width:16px; height:16px;}
        .forgot-password {color:var(--accent-light); text-decoration:none; transition:var(--transition); font-weight:500;}
        .forgot-password:hover {color:white; text-decoration:underline;}
        .signup-link {text-align:center; margin-top:30px; color:var(--text-muted); font-size:14px;}
        .signup-link a {color:var(--accent-light); text-decoration:none; font-weight:600; transition:var(--transition); margin-left:5px;}
        .signup-link a:hover {color:white; text-decoration:underline;}
        .login-form::-webkit-scrollbar {width:6px;}
        .login-form::-webkit-scrollbar-track {background:rgba(255,255,255,0.1); border-radius:3px;}
        .login-form::-webkit-scrollbar-thumb {background:var(--accent); border-radius:3px;}
        .login-form::-webkit-scrollbar-thumb:hover {background:var(--accent-light);}
        @media (max-width:992px){.login-container{height:95vh; max-height:750px;}.login-form{padding:35px;}}
        @media (max-width:768px){.login-container{grid-template-columns:1fr; height:100vh; max-height:none; border-radius:0;}.login-image{display:none;}.login-form{padding:40px 30px;}.back-home{top:20px; right:20px;}}
        @media (max-width:576px){.login-form{padding:30px 20px;}.brand{margin-bottom:30px;}.login-header{margin-bottom:30px;}.login-options{flex-direction:column; gap:12px; align-items:flex-start;}.back-home{top:15px; right:15px; width:40px; height:40px;}}
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-image">
                <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" alt="Teen students supporting each other">
                <div class="image-overlay">
                    <h3>Peer Support Matters</h3>
                    <p>Join a community where students help each other grow and thrive</p>
                </div>
            </div>
            
            <div class="login-form">
                <a href="/" class="back-home">
                    <i class="fas fa-arrow-left"></i>
                </a>
                
                <div class="form-content">
                    <div class="brand">
                        <div class="logo">ME</div>
                        <div class="brand-text">
                            <h1>MindEase</h1>
                            <p>Emotional Support & Guidance</p>
                        </div>
                    </div>
                    
                    <div class="login-header">
                        <h2>Welcome Back</h2>
                        <p>Sign in to your account to continue your journey to wellness</p>
                    </div>

                    <!-- Display Errors -->
                    @if($errors->any())
                        <div style="color: #ff6b6b; margin-bottom: 15px;">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Login Form -->
                    <form id="loginForm" method="POST" action="{{ route('login.authenticate') }}">
                        @csrf

                        @if ($errors->has('login'))
                            <div style="color: #ff6b6b; margin-bottom: 15px;">
                                {{ $errors->first('login') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="schoolId">School ID</label>
                            <div class="input-with-icon">
                                <i class="fas fa-id-card"></i>
                                <input type="text" id="schoolId" name="schoolId" class="form-control" placeholder="Enter your School ID" value="{{ old('schoolId') }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-with-icon">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                        </div>
                        
                        <div class="login-options">
                            <div class="remember-me">
                                <input type="checkbox" id="remember">
                                <label for="remember">Remember me</label>
                            </div>
                            <a href="#" class="forgot-password">Forgot Password?</a>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </form>
                    
                    <div class="signup-link">
                        Don't have an account?<a href="{{ route('signup') }}">Sign up here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
