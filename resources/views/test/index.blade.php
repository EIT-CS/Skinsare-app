@extends('layouts.app')
@section('title', 'Арьсны тест - GlowMN')

@section('content')
<section class="quiz-section section-with-wave">
    <div class="container">
        <div class="quiz-container">
            <!-- Header -->
            <div class="quiz-header" data-aos="fade-down">
                <div class="section-badge mb-3">🔬 Шинжлэх ухааны арьсны тест</div>
                <h2 class="section-title">Арьсны төрлөө тодорхойлъё</h2>
                <p class="text-muted">Доорх {{ count($questions) }} асуултад шударгаар хариулна уу</p>

                <!-- Progress -->
                <div class="quiz-progress-bar mt-4">
                    <div class="quiz-progress-fill" id="quizProgress" style="width:0%"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="quiz-step-label">Асуулт <span id="stepLabel">1 / {{ count($questions) }}</span></span>
                    <span class="quiz-step-label" id="progressPct">0%</span>
                </div>
            </div>

            <!-- Quiz Form -->
            <form method="POST" action="{{ route('test.submit') }}" id="quizForm">
                @csrf
                @foreach($questions as $idx => $question)
                <div class="quiz-card {{ $idx === 0 ? 'active' : '' }}" data-qid="{{ $question['id'] }}">
                    <div class="quiz-q-number">{{ $idx + 1 }}</div>
                    <div class="quiz-question">{{ $question['text'] }}</div>

                    <div class="quiz-options">
                        @foreach($question['options'] as $optIdx => $option)
                        <div class="quiz-option" data-option-idx="{{ $optIdx }}"
                             onclick="this.closest('.quiz-card').querySelectorAll('.quiz-option').forEach(o=>o.classList.remove('selected')); this.classList.add('selected'); document.querySelector('#answer_{{ $question['id'] }}') ? document.querySelector('#answer_{{ $question['id'] }}').value='{{ $optIdx }}' : (() => { let h=document.createElement('input'); h.type='hidden'; h.name='answers[{{ $question['id'] }}]'; h.id='answer_{{ $question['id'] }}'; h.value='{{ $optIdx }}'; document.getElementById('quizForm').appendChild(h); })(); this.closest('.quiz-card').querySelector('.btn-quiz-next').disabled=false;">
                            <div class="option-radio"></div>
                            <span>{{ $option['label'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="quiz-nav">
                        @if($idx > 0)
                            <button type="button" class="btn-quiz-nav btn-quiz-prev">
                                ← Өмнөх
                            </button>
                        @else
                            <div></div>
                        @endif

                        <button type="button"
                            class="btn-quiz-nav btn-quiz-next"
                            {{ $idx === count($questions) - 1 ? 'data-last=1' : '' }}
                            disabled>
                            {{ $idx === count($questions) - 1 ? '✓ Үр дүн харах' : 'Дараах →' }}
                        </button>
                    </div>
                </div>
                @endforeach
            </form>

            <!-- Info Box -->
            <div class="text-center mt-4" style="color: var(--gray-3); font-size: 13px;">
                <i class="fa fa-shield-alt me-1"></i>
                Таны хариулт нууцлагдмал. Тест нь зөвхөн мэдээлэл өгөх зорилготой.
            </div>
        </div>
    </div>
    <div class="wave" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none" role="presentation">
            <path d="M0,35 C300,70 600,0 900,35 L1200,35 L1200,70 L0,70 Z" fill="#5f3a9f"></path>
        </svg>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Override the inline onclick with cleaner version
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.quiz-option').forEach(opt => {
        opt.onclick = function() {
            const card = this.closest('.quiz-card');
            const qId = card.dataset.qid;
            const optIdx = this.dataset.optionIdx;

            card.querySelectorAll('.quiz-option').forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');

            let hidden = document.getElementById('answer_' + qId);
            if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'answers[' + qId + ']';
                hidden.id = 'answer_' + qId;
                document.getElementById('quizForm').appendChild(hidden);
            }
            hidden.value = optIdx;

            const nextBtn = card.querySelector('.btn-quiz-next');
            if (nextBtn) {
                nextBtn.disabled = false;
                nextBtn.style.transform = 'scale(1.03)';
                setTimeout(() => nextBtn.style.transform = '', 200);
            }
        };
    });
});
</script>
@endpush
