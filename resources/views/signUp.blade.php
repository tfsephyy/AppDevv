<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindEase — Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
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

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #1a3c5e 0%, #2a5c8a 50%, #1a3c5e 100%);
            color: var(--text);
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            height: 100%;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signup-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 1200px;
            height: 95vh;
            background: var(--card-bg);
            border-radius: var(--radius);
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .signup-form {
            padding: 40px;
            overflow-y: auto;
            position: relative;
        }

        /* Custom scrollbar */
        .signup-form::-webkit-scrollbar {
            width: 8px;
        }

        .signup-form::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .signup-form::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 4px;
        }

        .signup-form::-webkit-scrollbar-thumb:hover {
            background: var(--accent-light);
        }

        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            font-size: 15px;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.15);
        }

        .btn {
            padding: 14px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            color: white;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success { background: #27ae60; color: white; }
        .alert-error { background: #e74c3c; color: white; }

        .error-text {
            color: #ffb3b3;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .input-with-icon {
            position: relative;
        }

        select.form-control {
            padding: 14px 15px 14px 45px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23e6f0f7' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            cursor: pointer;
        }

        select.form-control option {
            background: var(--accent);
            color: var(--text);
            padding: 10px;
        }

        select.form-control option:hover {
            background: var(--accent-light);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        #program_other_container {
            display: none;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="signup-container">

        <div class="signup-form">

            <a href="/" style="color: white; text-decoration:none; position:absolute; right:20px; top:20px;">
                <i class="fas fa-arrow-left"></i>
            </a>

            <h2 style="margin-bottom:10px;">Join Our Community</h2>
            <p style="margin-bottom:20px; color:var(--text-muted);">Create your account</p>

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
                <div id="successAlert" class="alert alert-success" style="transition: opacity 0.5s ease-out;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Please fix the following:</strong>
                    <ul style="margin-left:20px; margin-top:10px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('signup.store') }}">
                @csrf

                {{-- SCHOOL ID --}}
                <label>School ID</label>
                <div class="input-with-icon">
                    <i class="fas fa-id-card" style="position:absolute; margin:12px;"></i>
                    <input type="text" name="schoolId" class="form-control" value="{{ old('schoolId') }}" required>
                </div>
                @error('schoolId')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <br>

                {{-- NAME --}}
                <label>Name</label>
                <div class="input-with-icon">
                    <i class="fas fa-user" style="position:absolute; margin:12px;"></i>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                @error('name')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <br>

                {{-- EMAIL --}}
                <label>Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope" style="position:absolute; margin:12px;"></i>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <br>

                {{-- PROGRAM --}}
                <label>Program</label>
                <div class="input-with-icon">
                    <i class="fas fa-graduation-cap" style="position:absolute; margin:12px;"></i>
                    <select name="program" id="program" class="form-control" required>
                        <option value="">Select Program</option>
                        <option value="Bachelor of Science in Information Technology" {{ old('program') == 'Bachelor of Science in Information Technology' ? 'selected' : '' }}>Bachelor of Science in Information Technology</option>
                        <option value="Bachelor of Science in Computer Engineering" {{ old('program') == 'Bachelor of Science in Computer Engineering' ? 'selected' : '' }}>Bachelor of Science in Computer Engineering</option>
                        <option value="Bachelor of Arts in Political Science" {{ old('program') == 'Bachelor of Arts in Political Science' ? 'selected' : '' }}>Bachelor of Arts in Political Science</option>
                        <option value="Bachelor of Science in Hospitality Management" {{ old('program') == 'Bachelor of Science in Hospitality Management' ? 'selected' : '' }}>Bachelor of Science in Hospitality Management</option>
                        <option value="Bachelor of Science in Tourism Management" {{ old('program') == 'Bachelor of Science in Tourism Management' ? 'selected' : '' }}>Bachelor of Science in Tourism Management</option>
                        <option value="Bachelor of Science in Criminology" {{ old('program') == 'Bachelor of Science in Criminology' ? 'selected' : '' }}>Bachelor of Science in Criminology</option>
                        <option value="Bachelor of Science in Fisheries" {{ old('program') == 'Bachelor of Science in Fisheries' ? 'selected' : '' }}>Bachelor of Science in Fisheries</option>
                        <option value="Bachelor of Elementary Education" {{ old('program') == 'Bachelor of Elementary Education' ? 'selected' : '' }}>Bachelor of Elementary Education</option>
                        <option value="Others" {{ old('program') == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                </div>
                @error('program')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <br>

                {{-- PROGRAM OTHER --}}
                <div id="program_other_container">
                    <label>Specify Program</label>
                    <div class="input-with-icon">
                        <i class="fas fa-edit" style="position:absolute; margin:12px;"></i>
                        <input type="text" name="program_other" id="program_other" class="form-control" value="{{ old('program_other') }}" placeholder="Please specify your program">
                    </div>
                    @error('program_other')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                    <br>
                </div>

                {{-- YEAR AND SECTION --}}
                <div class="form-row">
                    <div>
                        <label>Year</label>
                        <div class="input-with-icon">
                            <i class="fas fa-calendar" style="position:absolute; margin:12px;"></i>
                            <select name="year" class="form-control" required>
                                <option value="">Select Year</option>
                                <option value="1" {{ old('year') == '1' ? 'selected' : '' }}>1st Year</option>
                                <option value="2" {{ old('year') == '2' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3" {{ old('year') == '3' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4" {{ old('year') == '4' ? 'selected' : '' }}>4th Year</option>
                            </select>
                        </div>
                        @error('year')
                            <small class="error-text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label>Section</label>
                        <div class="input-with-icon">
                            <i class="fas fa-users" style="position:absolute; margin:12px;"></i>
                            <select name="section" class="form-control" required>
                                <option value="">Select Section</option>
                                <option value="1" {{ old('section') == '1' ? 'selected' : '' }}>Section 1</option>
                                <option value="2" {{ old('section') == '2' ? 'selected' : '' }}>Section 2</option>
                                <option value="3" {{ old('section') == '3' ? 'selected' : '' }}>Section 3</option>
                                <option value="4" {{ old('section') == '4' ? 'selected' : '' }}>Section 4</option>
                            </select>
                        </div>
                        @error('section')
                            <small class="error-text">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <br>

                {{-- PASSWORD --}}
                <label>Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock" style="position:absolute; margin:12px;"></i>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                @error('password')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <br>

                {{-- CONFIRM PASSWORD --}}
                <label>Confirm Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock" style="position:absolute; margin:12px;"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
                <small id="passwordMatchMessage" class="error-text" style="display:none;">
                    Passwords do not match.
                </small>
                @error('password_confirmation')
                    <small class="error-text">{{ $message }}</small>
                @enderror

                <button type="submit" class="btn">Create Account</button>
            </form>

            <p style="margin-top:20px; text-align:center;">
                Already have an account?
                <a href="{{ route('login') }}" style="color:var(--accent-light);">Login here</a>
            </p>

        </div>

        <div>
            <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&w=1200&q=80"
                 style="width:100%; height:100%; object-fit:cover;">
        </div>
    </div>
</div>

<script>
    // Auto-hide success alert
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            setTimeout(() => {
                successAlert.remove();
            }, 500);
        }, 3000);
    }

    const pass = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const msg = document.getElementById('passwordMatchMessage');

    confirm.addEventListener('input', () => {
        if (pass.value !== confirm.value) {
            confirm.style.borderColor = "#e74c3c";
            msg.style.display = "block";
        } else {
            confirm.style.borderColor = "var(--accent)";
            msg.style.display = "none";
        }
    });

    // Show/hide program_other field based on program selection
    const programSelect = document.getElementById('program');
    const programOtherContainer = document.getElementById('program_other_container');
    const programOtherInput = document.getElementById('program_other');

    programSelect.addEventListener('change', () => {
        if (programSelect.value === 'Others') {
            programOtherContainer.style.display = 'block';
            programOtherInput.required = true;
        } else {
            programOtherContainer.style.display = 'none';
            programOtherInput.required = false;
            programOtherInput.value = '';
        }
    });

    // Check on page load in case of validation errors
    if (programSelect.value === 'Others') {
        programOtherContainer.style.display = 'block';
        programOtherInput.required = true;
    }
</script>

</body>
</html>
