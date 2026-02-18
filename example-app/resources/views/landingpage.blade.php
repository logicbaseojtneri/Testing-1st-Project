<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="ManageX - Manage projects and tasks efficiently" />
        <meta name="author" content="ManageX Team" />
        <title>ManageX - Project Management Made Simple</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)--> 
        <link href="{{ asset('css_2/styles.css') }}" rel="stylesheet" />
        <style>
            :root {
                --primary: #001f3f;
                --primary-dark: #001428;
                --white: #ffffff;
                --light-bg: #f8f9fa;
                --text-dark: #1a1a1a;
                --text-muted: #6c757d;
                --border: #e9ecef;
            }
            * { margin: 0; padding: 0; box-sizing: border-box; }
            html, body { height: 100%; width: 100%; }
            body { 
                background: linear-gradient(180deg, var(--white) 0%, #f0f3f9 100%);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                color: var(--text-dark);
                overflow-x: hidden;
            }
            
            /* Navbar */
            .navbar-landing {
                background: var(--white) !important;
                box-shadow: 0 2px 12px rgba(0, 31, 63, 0.08);
                padding: 1rem 0;
            }
            .navbar-brand { 
                color: var(--white) !important;
                font-weight: 800;
                font-size: 1.4rem;
                letter-spacing: -0.5px;
            }
            .nav-link { 
                color: var(--text-dark) !important;
                font-weight: 500;
                margin: 0 0.5rem;
                transition: all 0.3s ease;
                position: relative;
            }
            .nav-link:hover { 
                color: var(--primary) !important;
            }
            .nav-link::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 0;
                width: 0;
                height: 2px;
                background: var(--primary);
                transition: width 0.3s ease;
            }
            .nav-link:hover::after {
                width: 100%;
            }
            
            /* Hero Section */
            .hero-section {
                padding: 4rem 0;
                position: relative;
                overflow: hidden;
            }
            .hero-section::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -10%;
                width: 500px;
                height: 500px;
                background: radial-gradient(circle, rgba(0, 31, 63, 0.08) 0%, transparent 70%);
                border-radius: 50%;
                z-index: 0;
            }
            .hero-container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 3rem;
                align-items: center;
                position: relative;
                z-index: 1;
            }
            .hero-content h1 {
                font-size: 3rem;
                font-weight: 800;
                line-height: 1.2;
                margin-bottom: 1rem;
                color: var(--primary);
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            .hero-content p {
                font-size: 1.1rem;
                color: var(--text-muted);
                margin-bottom: 2rem;
                line-height: 1.6;
            }
            .hero-buttons {
                display: flex;
                gap: 1rem;
                flex-wrap: wrap;
            }
            .btn-primary-custom {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                color: var(--white) !important;
                border: none;
                padding: 0.9rem 2rem;
                border-radius: 10px;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 8px 20px rgba(0, 31, 63, 0.2);
                text-decoration: none;
                display: inline-block;
            }
            .btn-primary-custom:hover {
                transform: translateY(-3px);
                box-shadow: 0 12px 30px rgba(0, 31, 63, 0.3);
            }
            .btn-secondary-custom {
                background: var(--white);
                color: var(--primary) !important;
                border: 2px solid var(--primary);
                padding: 0.8rem 1.95rem;
                border-radius: 10px;
                font-weight: 600;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-block;
            }
            .btn-secondary-custom:hover {
                background: var(--primary);
                color: var(--white) !important;
                transform: translateY(-3px);
            }
            .hero-image {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 400px;
                background: linear-gradient(135deg, rgba(0, 31, 63, 0.08) 0%, rgba(0, 31, 63, 0.04) 100%);
                border-radius: 16px;
                border: 2px solid var(--border);
                overflow: hidden;
            }
            .hero-image img {
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
            }
            
            /* Features Section */
            .features-section {
                padding: 5rem 0;
                background: var(--white);
            }
            .section-header {
                text-align: center;
                margin-bottom: 4rem;
            }
            .section-header h2 {
                font-size: 2.5rem;
                font-weight: 800;
                color: var(--primary);
                margin-bottom: 1rem;
            }
            .section-header p {
                font-size: 1.1rem;
                color: var(--text-muted);
                max-width: 600px;
                margin: 0 auto;
            }
            .feature-card {
                background: var(--white);
                border: 2px solid var(--border);
                border-radius: 12px;
                padding: 2rem;
                text-align: center;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            .feature-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
                transform: scaleX(0);
                transition: transform 0.3s ease;
            }
            .feature-card:hover {
                border-color: var(--primary);
                box-shadow: 0 12px 30px rgba(0, 31, 63, 0.12);
                transform: translateY(-5px);
            }
            .feature-card:hover::before {
                transform: scaleX(1);
            }
            .feature-icon {
                width: 60px;
                height: 60px;
                margin: 0 auto 1.5rem;
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.8rem;
                color: var(--white);
            }
            .feature-card h3 {
                font-size: 1.3rem;
                font-weight: 700;
                color: var(--primary);
                margin-bottom: 1rem;
            }
            .feature-card p {
                color: var(--text-muted);
                line-height: 1.6;
            }
            

            .form-floating > label {
                color: var(--text-dark);
                font-weight: 600;
            }
            
            /* Footer */
            footer {
                background: var(--primary);
                color: var(--white);
                padding: 2rem 0;
                text-align: center;
            }
            footer a {
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
                transition: color 0.3s ease;
            }
            footer a:hover {
                color: var(--white);
            }
            
            /* Responsive */
            @media (max-width: 992px) {
                .hero-container {
                    grid-template-columns: 1fr;
                }
                .hero-content h1 {
                    font-size: 2.2rem;
                }
                .hero-image {
                    height: 300px;
                }
            }
            @media (max-width: 576px) {
                .hero-content h1 {
                    font-size: 1.8rem;
                }
                .section-header h2 {
                    font-size: 1.8rem;
                }
                .hero-buttons {
                    flex-direction: column;
                }
                .btn-primary-custom, .btn-secondary-custom {
                    width: 100%;
                    text-align: center;
                }
            }
        </style>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-landing">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('login') }}" style="min-width:200px;">
                    <span style="color: #1a1a1a; font-weight: 800; font-size: 1.4rem; letter-spacing: -0.5px;">ManageX</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                        <li class="nav-item"><a class="btn-primary-custom" href="{{ route('login') }}" style="padding: 0.6rem 1.4rem; font-size: 0.95rem;">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-container">
                    <div class="hero-content">
                        <h1>Manage Your Projects Effortlessly</h1>
                        <p>Create projects, organize tasks, and collaborate with your team. Track progress in real-time with our intuitive Kanban board and keep everyone on the same page.</p>
                        <div class="hero-buttons">
                            <a href="{{ route('login') }}" class="btn-primary-custom">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Start
                            </a>
                        </div>
                    </div>
                    <div class="hero-image" style="display: flex; align-items: center; justify-content: center; min-height: 220px;">
                    </div>
                        <!-- Logo image removed from hero section -->
                </div>
            </div>
        </section>
        <!-- Features Section -->
        <section class="features-section" id="features">
            <div class="container">
                <div class="section-header">
                    <h2>Powerful Features</h2>
                    <p>Everything you need to manage projects and teams successfully</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-th"></i>
                            </div>
                            <h3>Kanban Board</h3>
                            <p>Visualize your workflow with an intuitive Kanban board. Organize tasks into To Do, In Progress, Review, and Done columns for better project management.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>Team Collaboration</h3>
                            <p>Assign tasks to team members, share projects, and collaborate seamlessly. Keep everyone updated with real-time project status and task assignments.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3>Track Progress</h3>
                            <p>Monitor project health at a glance. Track task status, completion rates, and project timelines to ensure everything stays on schedule.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-folder"></i>
                            </div>
                            <h3>Project Management</h3>
                            <p>Create and organize multiple projects with detailed descriptions. Manage project members and control who has access to each project.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>Smart Search</h3>
                            <p>Find tasks and projects instantly with powerful search and filter functionality. Sort by status, category, date, and more.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h3>Secure & Reliable</h3>
                            <p>Your data is secure with role-based access control. Only authorized team members can view and manage specific projects and tasks.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    

        <!-- Footer -->
        <footer>
            <div class="container">
                <p class="mb-0">&copy; 2024 ManageX. All rights reserved. | Built with <i class="fas fa-heart" style="color: #ff6b6b;"></i> for better project management</p>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js_2/scripts.js') }}"></script>

    </body>
</html>