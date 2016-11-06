@extends('layouts.main')
@section('content')
<div class="panel-group" id="accordion">
    @foreach ($faqcategoryItems as $faqcategoryItem)
    <div class="faqHeader">{{ $faqcategoryItem->{ "faqcategory_title_".Lang::locale()} }}</div>
    <div class="faqContent">{!! $faqcategoryItem->{ "faqcategory_description_".Lang::locale()} !!}</div>
        @foreach ($faqItems as $faqItem)
          @if($faqcategoryItem->id == $faqItem->faqcategory_id)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $faqItem->id }}">
                          {{ $faqItem->{ "faq_question_".Lang::locale()} }}
                        </a>
                    </h4>
                </div>
                <div id="collapse{{ $faqItem->id }}" class="panel-collapse collapse">
                    <div class="panel-body">
                        {!! $faqItem->{ "faq_answer_".Lang::locale()} !!}
                    </div>
                </div>
            </div>
          @endif
        @endforeach
    @endforeach
</div>
@stop
