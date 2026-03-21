<?php
// pages/admissions.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container-fluid py-5 bg-primary text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);">
    <div class="container position-relative z-index-1 py-4">
        <h1 class="display-4 fw-bold mb-3">Admissions Information</h1>
        <p class="lead text-white-50">Join our community of excellence. Your journey starts here.</p>
    </div>
</div>

<div class="container py-5 my-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="glass-panel p-4 p-md-5 border-0 h-100">
                <h2 class="fw-bold mb-4 gradient-text border-bottom pb-3">Application Procedure</h2>
                
                <div class="d-flex mb-4">
            <h2 class="display-5 fw-bold mb-5 gradient-text text-center text-lg-start">Admission Steps</h2>
            
            <div class="admission-steps">
                <div class="d-flex mb-5 glass-panel p-4 border-0 align-items-center flex-column flex-md-row text-center text-md-start">
                    <div class="step-num mb-3 mb-md-0">
                        <span class="display-4 fw-bold text-primary opacity-25">01</span>
                    </div>
                    <div class="ms-md-4">
                        <h4 class="fw-bold text-dark">Review Programs</h4>
                        <p class="text-secondary">Browse our <a href="<?= $base_dir ?>pages/programs.php" class="text-primary text-decoration-none">academic programs</a> to find the one that fits your career goals.</p>
                    </div>
                </div>
                
                <div class="d-flex mb-5 glass-panel p-4 border-0 align-items-center flex-column flex-md-row text-center text-md-start">
                    <div class="step-num mb-3 mb-md-0">
                        <span class="display-4 fw-bold text-primary opacity-25">02</span>
                    </div>
                    <div class="ms-md-4">
                        <h4 class="fw-bold text-dark">Check Eligibility</h4>
                        <p class="text-secondary">Ensure you meet the minimum requirements for your chosen program, including academic qualifications and age limits.</p>
                    </div>
                </div>
                
                <div class="d-flex mb-5 glass-panel p-4 border-0 align-items-center flex-column flex-md-row text-center text-md-start">
                    <div class="step-num mb-3 mb-md-0">
                        <span class="display-4 fw-bold text-primary opacity-25">03</span>
                    </div>
                    <div class="ms-md-4">
                        <h4 class="fw-bold text-dark">Submit Application</h4>
                        <p class="text-secondary">Download the application form from our <a href="<?= $base_dir ?>pages/downloads.php" class="text-primary text-decoration-none">Document Center</a>, fill it out, and submit it to the registrar's office.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="glass-panel p-4 p-md-5 text-center sticky-top" style="top: 100px;">
                <i class="bi bi-file-earmark-check display-1 text-primary mb-3"></i>
                <h3 class="fw-bold mb-4">Ready to Apply?</h3>
                <p class="text-secondary mb-4">Download the official application form to begin your journey with us.</p>
                <a href="<?= $base_dir ?>pages/downloads.php" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold fs-5 mb-3">Get Application Form</a>
                
                <hr class="text-secondary my-4">
                
                <div class="text-start">
                    <h5 class="fw-bold mb-3"><i class="bi bi-info-circle text-info me-2"></i> Important Deadlines</h5>
                    <ul class="list-group list-group-flush bg-transparent">
                        <li class="list-group-item bg-transparent px-0 border-secondary d-flex justify-content-between">
                            <span class="text-secondary">Fall Semester:</span> <span class="fw-bold text-dark">August 15</span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 border-secondary d-flex justify-content-between">
                            <span class="text-secondary">Spring Semester:</span> <span class="fw-bold text-dark">December 15</span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 border-secondary d-flex justify-content-between">
                            <span class="text-secondary">Summer Session:</span> <span class="fw-bold text-dark">April 30</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
