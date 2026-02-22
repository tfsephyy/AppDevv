<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MindEase — Information</title>
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
            --sidebar-bg: #0f3a1a;
            --radius: 12px;
            --transition: all 0.3s ease;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #6bb3ff 0%, #4a90e2 100%);
            color: var(--text);
            line-height: 1.5;
            height: 100vh;
            overflow: hidden;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, rgba(26, 60, 94, 0.95), rgba(42, 92, 138, 0.95));
            height: 100vh;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .logo {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
        }

        .brand-text h1 {
            margin: 0;
            font-size: 20px;
            background: linear-gradient(to right, #ffffff, var(--accent-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .brand-text p {
            margin: 0;
            font-size: 12px;
            color: var(--text-muted);
        }

        .nav-links {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 0 15px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text);
        }

        .nav-item.active {
            background: var(--accent);
            color: white;
        }

        .nav-item i {
            width: 20px;
            font-size: 16px;
        }

        .admin-profile {
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .admin-info h3 {
            margin: 0;
            font-size: 14px;
        }

        .admin-info p {
            margin: 0;
            font-size: 12px;
            color: var(--text-muted);
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .top-bar {
            padding: 20px 30px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .page-title p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .admin-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .notification-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--card-bg);
            color: var(--text);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
        }

        .notification-btn:hover {
            background: var(--glass);
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .information-content {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
        }

        .info-section {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 25px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }

        .info-section h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: var(--accent);
        }

        .info-section h3 {
            margin: 25px 0 15px 0;
            font-size: 20px;
            color: var(--accent-light);
        }

        .info-section p {
            margin-bottom: 15px;
            line-height: 1.6;
            color: var(--text);
        }

        .info-section ul {
            margin: 15px 0;
            padding-left: 20px;
        }

        .info-section li {
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .condition-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid var(--accent);
        }

        .condition-card h4 {
            margin-bottom: 10px;
            font-size: 18px;
            color: var(--accent-light);
        }

        .condition-card p {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .examples {
            background: rgba(255, 255, 255, 0.05);
            padding: 10px 15px;
            border-radius: 6px;
            margin-top: 10px;
        }

        .examples strong {
            color: var(--accent);
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }

        .page-btn {
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            background: var(--card-bg);
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
        }

        .page-btn:hover {
            background: var(--glass);
            color: var(--text);
        }

        .page-btn.active {
            background: var(--accent);
            color: white;
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Scrollbar */
        .information-content::-webkit-scrollbar {
            width: 6px;
        }

        .information-content::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .information-content::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 3px;
        }

        .information-content::-webkit-scrollbar-thumb:hover {
            background: var(--accent-light);
        }
    </style>
</head>
<body>
    @include('components.user-navigation')

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Information</h1>
                <p>Learn about mental health and common conditions</p>
            </div>

            <div class="admin-actions">
                <a href="#" class="notification-btn" id="notificationBtn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
                </a>
            </div>
        </div>

        <div class="information-content">
            <!-- What is Mental Health Section -->
            <div class="info-section">
                <h2>What Is Mental Health?</h2>
                <p>Mental health refers to your overall emotional and psychological well-being — how you think, feel, behave, and cope with stress. It influences how you handle problems, how you relate to others, how you make decisions, and how you see yourself.</p>
                <p>Good mental health doesn't mean you never struggle; it means you can adapt, recover, and continue functioning day to day.</p>
            </div>

            <!-- Mental Health Conditions Section -->
            <div class="info-section">
                <h2>8 Common Mental Health Conditions</h2>

                <!-- Pagination Controls -->
                <div class="pagination" id="paginationControls">
                    <button class="page-btn" id="prevBtn" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <button class="page-btn active" data-page="1">1</button>
                    <button class="page-btn" data-page="2">2</button>
                    <button class="page-btn" data-page="3">3</button>
                    <button class="page-btn" data-page="4">4</button>
                    <button class="page-btn" data-page="5">5</button>
                    <button class="page-btn" data-page="6">6</button>
                    <button class="page-btn" data-page="7">7</button>
                    <button class="page-btn" data-page="8">8</button>
                    <button class="page-btn" id="nextBtn">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Condition 1: Anxiety Disorders -->
                <div class="condition-card" data-page="1">
                    <h3>1. Anxiety Disorders</h3>
                    <p>These involve intense, persistent worry or fear that is harder to control and stronger than normal everyday anxiety. People may feel constantly "on edge," have racing thoughts, or avoid situations that trigger fear. Physical symptoms like fast heartbeat, sweating, trembling, or stomach discomfort can also appear.</p>
                    <div class="examples">
                        <strong>Examples:</strong>
                        <ul>
                            <li>Generalized Anxiety Disorder (GAD)</li>
                            <li>Panic Disorder</li>
                            <li>Social Anxiety</li>
                            <li>Specific Phobias</li>
                        </ul>
                    </div>
                </div>

                <!-- Condition 2: Depressive Disorders -->
                <div class="condition-card" data-page="2">
                    <h3>2. Depressive Disorders</h3>
                    <p>Depression is more than sadness. It's a lasting period of low mood, lack of energy, and loss of interest in activities that used to be enjoyable. It may cause changes in sleep, appetite, concentration, and motivation. People may feel hopeless, tired, or overwhelmed for weeks or months.</p>
                    <div class="examples">
                        <strong>Examples:</strong>
                        <ul>
                            <li>Major Depressive Disorder</li>
                            <li>Persistent Depressive Disorder (Dysthymia)</li>
                        </ul>
                    </div>
                </div>

                <!-- Condition 3: Bipolar Disorder -->
                <div class="condition-card" data-page="3">
                    <h3>3. Bipolar Disorder</h3>
                    <p>A condition involving extreme shifts in mood and energy. People alternate between:</p>
                    <ul>
                        <li><strong>Manic/hypomanic episodes:</strong> increased energy, fast thinking, risky decisions, feeling unusually confident</li>
                        <li><strong>Depressive episodes:</strong> low mood, tiredness, low motivation, sadness</li>
                    </ul>
                    <p>These mood changes are stronger than ordinary ups and downs and can affect daily life, work, and relationships.</p>
                </div>

                <!-- Condition 4: Trauma- and Stressor-Related Disorders -->
                <div class="condition-card" data-page="4">
                    <h3>4. Trauma- and Stressor-Related Disorders</h3>
                    <p>These develop after experiencing or witnessing a traumatic, frightening, or overwhelming event. The mind continues to react as if the danger is still present. People may have flashbacks, nightmares, sudden fear, or strong emotional reactions to reminders of the event. Avoiding situations or thinking about the trauma is also common.</p>
                    <div class="examples">
                        <strong>Example:</strong> Post-Traumatic Stress Disorder (PTSD)
                    </div>
                </div>

                <!-- Condition 5: Obsessive-Compulsive and Related Disorders -->
                <div class="condition-card" data-page="5">
                    <h3>5. Obsessive-Compulsive and Related Disorders</h3>
                    <p>These conditions involve:</p>
                    <ul>
                        <li><strong>Obsessions:</strong> unwanted, intrusive thoughts or fears</li>
                        <li><strong>Compulsions:</strong> repeated behaviors or rituals done to try to reduce anxiety</li>
                    </ul>
                    <p>Performing these rituals may bring temporary relief, but the cycle often returns. It can interfere with school, work, or daily routines.</p>
                    <div class="examples">
                        <strong>Example:</strong> Obsessive-Compulsive Disorder (OCD)
                    </div>
                </div>

                <!-- Condition 6: Eating Disorders -->
                <div class="condition-card" data-page="6">
                    <h3>6. Eating Disorders</h3>
                    <p>These involve unhealthy patterns related to food, body weight, and self-image. They can affect physical health, emotions, and daily functioning. People may restrict food, overeat, purge, or feel intense distress about body shape.</p>
                    <div class="examples">
                        <strong>Examples:</strong>
                        <ul>
                            <li>Anorexia Nervosa</li>
                            <li>Bulimia Nervosa</li>
                            <li>Binge-Eating Disorder</li>
                        </ul>
                    </div>
                </div>

                <!-- Condition 7: Personality Disorders -->
                <div class="condition-card" data-page="7">
                    <h3>7. Personality Disorders</h3>
                    <p>These involve long-term patterns of thinking, feeling, and behaving that differ significantly from cultural expectations. They can affect self-image, relationships, and emotional control. People with personality disorders may have difficulty managing emotions, maintaining stable relationships, or responding to stress in flexible ways.</p>
                    <div class="examples">
                        <strong>Examples:</strong>
                        <ul>
                            <li>Borderline Personality Disorder</li>
                            <li>Narcissistic Personality Disorder</li>
                            <li>Avoidant Personality Disorder</li>
                        </ul>
                    </div>
                </div>

                <!-- Condition 8: Neurodevelopmental Disorders -->
                <div class="condition-card" data-page="8">
                    <h3>8. Neurodevelopmental Disorders</h3>
                    <p>These start in childhood and affect how the brain grows and functions. They influence learning, communication, behavior, attention, or social interaction. People may have challenges with focus, organization, impulse control, or understanding social cues.</p>
                    <div class="examples">
                        <strong>Examples:</strong>
                        <ul>
                            <li>Attention-Deficit/Hyperactivity Disorder (ADHD)</li>
                            <li>Autism Spectrum Disorder (ASD)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Pagination functionality
        let currentPage = 1;
        const totalPages = 8;
        const conditions = document.querySelectorAll('.condition-card');
        const pageButtons = document.querySelectorAll('.page-btn[data-page]');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        function showPage(page) {
            // Hide all conditions
            conditions.forEach(condition => {
                condition.style.display = 'none';
            });

            // Show current page condition
            const currentCondition = document.querySelector(`.condition-card[data-page="${page}"]`);
            if (currentCondition) {
                currentCondition.style.display = 'block';
            }

            // Update button states
            pageButtons.forEach(btn => {
                btn.classList.remove('active');
                if (parseInt(btn.dataset.page) === page) {
                    btn.classList.add('active');
                }
            });

            // Update prev/next buttons
            prevBtn.disabled = page === 1;
            nextBtn.disabled = page === totalPages;

            currentPage = page;
        }

        // Event listeners for page buttons
        pageButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const page = parseInt(btn.dataset.page);
                showPage(page);
            });
        });

        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                showPage(currentPage - 1);
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                showPage(currentPage + 1);
            }
        });

        // Initialize first page
        showPage(1);
    </script>
</body>
</html>
