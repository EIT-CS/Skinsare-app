// ============================================
//  GLOWMN - Main JavaScript
// ============================================

document.addEventListener('DOMContentLoaded', function () {

    // ---- Navbar scroll effect ----
    const navbar = document.querySelector('.navbar-main');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 30);
        });
    }

    // ---- Simple AOS (Animate on Scroll) ----
    const aosEls = document.querySelectorAll('[data-aos]');
    if (aosEls.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('aos-animate');
                }
            });
        }, { threshold: 0.12 });
        aosEls.forEach(el => observer.observe(el));
    }

    // ---- Quiz Logic ----
    const quizForm = document.getElementById('quizForm');
    if (quizForm) {
        initQuiz();
    }

    // ---- Score bars animate on result page ----
    const scoreBars = document.querySelectorAll('.score-bar-fill[data-width]');
    if (scoreBars.length) {
        setTimeout(() => {
            scoreBars.forEach(bar => {
                bar.style.width = bar.dataset.width + '%';
            });
        }, 400);
    }

    // ---- Auto-dismiss flash alerts ----
    const alerts = document.querySelectorAll('.alert-float');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'all 0.4s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(100%)';
            setTimeout(() => alert.remove(), 400);
        }, 4000);
    });

    // ---- Password visibility toggle ----
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function () {
            const target = document.querySelector(this.dataset.target);
            if (!target) return;
            const isText = target.type === 'text';
            target.type = isText ? 'password' : 'text';
            this.innerHTML = isText
                ? '<i class="fa fa-eye"></i>'
                : '<i class="fa fa-eye-slash"></i>';
        });
    });

    // ---- Admin delete confirm ----
    document.querySelectorAll('.btn-delete-confirm').forEach(btn => {
        btn.addEventListener('click', function (e) {
            if (!confirm('Устгахдаа итгэлтэй байна уу?')) {
                e.preventDefault();
            }
        });
    });

    // ---- Skin type filter buttons ----
    document.querySelectorAll('.filter-btn[data-filter]').forEach(btn => {
        btn.addEventListener('click', function () {
            const url = new URL(window.location.href);
            const key = this.dataset.filterKey || 'skin_type';
            const val = this.dataset.filter;
            if (val === '') {
                url.searchParams.delete(key);
            } else {
                url.searchParams.set(key, val);
            }
            url.searchParams.delete('page');
            window.location = url.toString();
        });
    });

    // ---- Image preview for file inputs ----
    document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
        input.addEventListener('change', function () {
            const preview = document.querySelector(this.dataset.preview);
            if (!preview) return;
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => { preview.src = e.target.result; };
                reader.readAsDataURL(file);
            }
        });
    });

});

// ============================================
//  QUIZ
// ============================================
function initQuiz() {
    const cards = document.querySelectorAll('.quiz-card');
    const progressFill = document.getElementById('quizProgress');
    const stepLabel = document.getElementById('stepLabel');
    const totalSteps = cards.length;
    let currentStep = 0;
    const answers = {};

    function showStep(idx) {
        cards.forEach((c, i) => c.classList.toggle('active', i === idx));
        const pct = ((idx) / totalSteps) * 100;
        if (progressFill) progressFill.style.width = pct + '%';
        if (stepLabel) stepLabel.textContent = (idx + 1) + ' / ' + totalSteps;
        updateNavButtons(idx);
    }

    function updateNavButtons(idx) {
        const card = cards[idx];
        const prevBtn = card.querySelector('.btn-quiz-prev');
        const nextBtn = card.querySelector('.btn-quiz-next');
        if (prevBtn) prevBtn.style.display = idx === 0 ? 'none' : 'inline-flex';
        const qId = card.dataset.qid;
        if (nextBtn) nextBtn.disabled = !(qId && answers[qId] !== undefined);
    }

    // Option selection
    document.querySelectorAll('.quiz-option').forEach(opt => {
        opt.addEventListener('click', function () {
            const card = this.closest('.quiz-card');
            const qId = card.dataset.qid;
            card.querySelectorAll('.quiz-option').forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            answers[qId] = parseInt(this.dataset.optionIdx);

            // Update hidden input
            let hidden = document.getElementById('answer_' + qId);
            if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'answers[' + qId + ']';
                hidden.id = 'answer_' + qId;
                document.getElementById('quizForm').appendChild(hidden);
            }
            hidden.value = this.dataset.optionIdx;

            // Enable next button
            const nextBtn = card.querySelector('.btn-quiz-next');
            if (nextBtn) {
                nextBtn.disabled = false;
                // Small bounce
                nextBtn.style.transform = 'scale(1.05)';
                setTimeout(() => { nextBtn.style.transform = ''; }, 200);
            }
        });
    });

    // Next buttons
    document.querySelectorAll('.btn-quiz-next').forEach(btn => {
        btn.addEventListener('click', function () {
            const isLast = this.dataset.last === '1';
            if (isLast) {
                document.getElementById('quizForm').submit();
                return;
            }
            if (currentStep < totalSteps - 1) {
                currentStep++;
                showStep(currentStep);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });

    // Prev buttons
    document.querySelectorAll('.btn-quiz-prev').forEach(btn => {
        btn.addEventListener('click', function () {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    showStep(0);
}