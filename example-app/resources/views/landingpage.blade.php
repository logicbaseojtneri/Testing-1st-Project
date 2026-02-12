<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Business Frontpage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)--> 
        <link href="{{ asset('css_2/styles.css') }}" rel="stylesheet" />
        <style>
            :root{ --primary: #4e73df; --primary-600: #6b86ea; --primary-dark: #2e59d9; --muted:#6c757d; }
            body { background: linear-gradient(180deg, #f6f8ff 0%, #ffffff 100%); }
            .page-frame{ max-width:1200px; margin: 3.5rem auto; background: linear-gradient(180deg, rgba(78,115,223,0.03), rgba(255,255,255,0.6)); border-radius: 18px; padding: 36px; box-shadow: 0 12px 40px rgba(46,89,223,0.06); border: 1px solid rgba(78,115,223,0.06); }
            .navbar-light .navbar-brand { color: var(--primary); font-weight: 700; }
            .navbar-light .nav-link { color: rgba(0,0,0,0.65); }
            .navbar-light .nav-link:hover { color: var(--primary); }
            .header-hero{ padding: 0; }
            .hero-grid{ display: flex; gap: 2.5rem; align-items: center; }
            .hero-left{ flex: 1.05; }
            .hero-right{ flex: 0.95; display:flex; align-items:center; justify-content:center; }
            .hero-card-inner{ background: #fff; border-radius: 14px; padding: 48px 40px; box-shadow: 0 14px 40px rgba(46,89,223,0.06); }
            /* hero icon removed */
            .hero-title{ color: #232323; font-weight: 800; font-size: 2.6rem; line-height:1.05; margin-bottom: 0.5rem; }
            .hero-sub{ color: var(--muted); font-size:1.05rem; max-width:640px; margin-bottom: 1.6rem; }
            .btn-gradient{ background: linear-gradient(90deg,var(--primary),var(--primary-600)); color:#fff; border: none; padding: 0.85rem 1.6rem; font-size:1rem; border-radius: 10px; box-shadow: 0 8px 20px rgba(78,115,223,0.12); }
            .btn-outline-primary{ color: var(--primary); border: 1px solid rgba(78,115,223,0.14); background: #fff; padding:0.85rem 1.6rem; border-radius:10px; }
            .hero-illustration{ width:100%; height:320px; border-radius:12px; background: linear-gradient(135deg, rgba(255,200,220,0.15), rgba(200,230,255,0.12)); display:flex; align-items:center; justify-content:center; }
            .feature .bi { color: var(--primary); font-size: 1.5rem; }
            footer.py-5 { background: transparent; }
            @media (max-width: 992px){ .hero-grid{ flex-direction:column-reverse; } .hero-illustration{ height:260px; } }
            @media (max-width: 576px){ .page-frame{ margin:1.5rem; padding:18px; } .hero-title{ font-size:1.6rem; } }
        </style>
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container px-5">
                <a class="navbar-brand" href="{{ route('login') }}">Task Management</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Docs</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="header-hero">
            <div class="page-frame">
                <div class="hero-grid">
                    <div class="hero-left">
                        <div class="hero-card-inner">
                            <h1 class="hero-title">Welcome to Task Management Application</h1>
                            <p class="hero-sub">Create projects, auto-assign tasks to developers, and track progress — all from one dashboard.</p>
                            <div class="d-flex gap-3">
                                <a class="btn btn-gradient" href="{{ route('login') }}">Login</a>
                                <a class="btn btn-outline-primary" href="{{ route('register') }}">Register</a>
                            </div>
                        </div>
                    </div>
                    <div class="hero-right">
                        <div class="hero-illustration">
                            <!-- Illustration placeholder - replace with actual image if available -->
                            <img src="{{ asset('images/illustration.png') }}" alt="Illustration" style="max-width:92%; max-height:92%; object-fit:contain; border-radius:8px;" onerror="this.style.display='none'">
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Features section-->
        <section class="py-5 border-bottom" id="features">
            <div class="container px-5 my-5">
                <div class="row gx-5">
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                        <h2 class="h4 fw-bolder">Featured title</h2>
                        <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
                        <a class="text-decoration-none" href="#!">
                            Call to action
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-building"></i></div>
                        <h2 class="h4 fw-bolder">Featured title</h2>
                        <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
                        <a class="text-decoration-none" href="#!">
                            Call to action
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                        <h2 class="h4 fw-bolder">Featured title</h2>
                        <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
                        <a class="text-decoration-none" href="#!">
                            Call to action
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Contact section-->
        <section class="bg-light py-5">
            <div class="container px-5 my-5 px-5">
                <div class="text-center mb-5">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-envelope"></i></div>
                    <h2 class="fw-bolder">Get in touch</h2>
                    <p class="lead mb-0">We'd love to hear from you</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-6">
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- * * SB Forms Contact Form * *-->
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- This form is pre-integrated with SB Forms.-->
                        <!-- To make this form functional, sign up at-->
                        <!-- https://startbootstrap.com/solution/contact-forms-->
                        <!-- to get an API token!-->
                        <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                                <label for="name">Full name</label>
                                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                            </div>
                            <!-- Email address input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" type="email" placeholder="name@example.com" data-sb-validations="required,email" />
                                <label for="email">Email address</label>
                                <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                                <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                            </div>
                            <!-- Phone number input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="phone" type="tel" placeholder="(123) 456-7890" data-sb-validations="required" />
                                <label for="phone">Phone number</label>
                                <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.</div>
                            </div>
                            <!-- Message input-->
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="message" type="text" placeholder="Enter your message here..." style="height: 10rem" data-sb-validations="required"></textarea>
                                <label for="message">Message</label>
                                <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                            </div>
                            <!-- Submit success message-->
                            <!---->
                            <!-- This is what your users will see when the form-->
                            <!-- has successfully submitted-->
                            <div class="d-none" id="submitSuccessMessage">
                                <div class="text-center mb-3">
                                    <div class="fw-bolder">Form submission successful!</div>
                                    To activate this form, sign up at
                                    <br />
                                    <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                </div>
                            </div>
                            <!-- Submit error message-->
                            <!---->
                            <!-- This is what your users will see when there is-->
                            <!-- an error submitting the form-->
                            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                            <!-- Submit Button-->
                            <div class="d-grid"><button class="btn btn-primary btn-lg disabled" id="submitButton" type="submit">Submit</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-5"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js_2/scripts.js') }}"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>