@foreach($faqs_groups as $group)
    <h5>{{ $group->title }}</h5>

        @foreach ($group->faq as $faq)
        <a href="#collapse{{ $faq->faq_group_id.$faq->id }}" data-toggle="collapse">
            {{ $faq->question }}
        </a>
        <div id="collapse{{ $faq->faq_group_id.$faq->id }}" class="panel-collapse collapse">
            <p>
                {{ $faq->answer }}
            </p>
        </div>
        @endforeach
    <hr>
@endforeach