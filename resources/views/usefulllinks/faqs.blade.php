@extends('layouts.app')
@section('title', 'FAQs - Pearls By HM')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">FAQ's</li>
            </ol>
        </nav>

        <h3 class="mb-4 fw-bold" style="font-family: Arial, sans-serif">FAQ's</h3>

        <div class="accordion" id="faqsAccordion">
            @forelse ($faqs as $faq)
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $faq->id }}">
                            {{ $faq->question }}
                        </button>
                    </h2>
                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqsAccordion">
                        <div class="accordion-body">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
            @empty
                <p>No FAQs available at the moment.</p>
            @endforelse
        </div>
    </div>
@endsection
