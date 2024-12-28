@extends("admin.layout.master")
@push("styles")
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-chat.css')}}">
@endpush
@section("page_title",getPageTitle())
@section("breadcrumbs")
{{-- <ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="javascript: void(0);">نازوکس</a></li>
    <li class="breadcrumb-item active">دَشبرد</li>
</ol> --}}
@endsection
@section("content")


<div class="app-chat card">

    <div class="col app-chat-history bg-body">
        <div class="chat-history-wrapper">
            <div class="chat-history-header border-bottom">
            <div class="row">
                <div class="col-md-8 col-12 d-flex">
                <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-contacts"></i>
                <div class="d-flex flex-shrink-0 avatar">
                    <img src="{{imageGenerator("images/avatars/".$ticket->ticketable?->id."/".$ticket->ticketable?->image,"rounded","avatar","public",false)}}" alt="آواتار" class="rounded-circle" data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-sidebar-right">
                </div>
                <div class="chat-contact-info flex-grow-1 ms-3">
                    <h6 class="m-0">{{$ticket->ticketable?->full_name}}</h6>
                    <small class="user-status text-muted">{{__("general.phone")}} : {{$ticket->ticketable?->phone}}</small>
                </div>
                </div>
                <div class="col-md-4 col-12">
                    @php
                    $status = generateObjectForComponent(\App\Enums\TicketStatus::toCollect(),"name","value");
                    @endphp
                    <x-admin.form.select  required="false" sectionClass="col-md-12" label="{{__('general.status')}}" name="status" :items="$status" selectedItem="{{$ticket->status}}"/>
                </div>

            </div>
            </div>
            <div class="chat-history-body bg-body ps ps__rtl ps--active-y">
            <ul class="list-unstyled chat-history mb-0">
                @foreach($ticket_messages as $ticket_message)
                @if($ticket_message->creator_type != "App\Models\Admin\Admin")
                <li class="chat-message chat-message-right">
                <div class="d-flex overflow-hidden">
                    <div class="chat-message-wrapper flex-grow-1">
                    <div class="chat-message-text">
                        <p class="mb-0">{{$ticket_message->message}}</p>
                        @if($ticket_message->ticketAttachments->count() > 0)
                        <hr>
                        <div class="d-flex">
                            @foreach($ticket_message->ticketAttachments as $attachment)
                            <a href="{{route('admin.tickets_management.tickets.attachment.download',encrypt($attachment->id))}}"><span class="attachment_box_in mx-2">{{$attachment->file}}</span></a>
                            @endforeach
                        </div>

                        @endif
                    </div>
                    <div class="text-end text-muted mt-1">
                        <i class="bx bx-check-double text-success"></i>
                        <small class="dir-ltr d-inline-block">{{$ticket->jalali_created_at}}</small>
                    </div>
                    </div>
                    <div class="user-avatar flex-shrink-0 ms-3">
                    <div class="avatar avatar-sm">
                        <img src="{{imageGenerator(null,"rounded","avatar","public",false)}}" alt="آواتار" class="rounded-circle">
                    </div>
                    </div>
                </div>
                </li>
                @else
                <li class="chat-message">
                    <div class="d-flex overflow-hidden">
                        <div class="user-avatar flex-shrink-0 me-3">
                        <div class="avatar avatar-sm">
                            <img src="{{imageGenerator("images/avatars/".$ticket_message->ticketMessagable->id."/".$ticket_message->ticketMessagable->image,"rounded","avatar","public",false)}}" alt="آواتار" class="rounded-circle">
                        </div>
                        </div>
                        <div class="chat-message-wrapper flex-grow-1">
                        <div class="chat-message-text">
                            <p class="mb-0">{{$ticket_message->message}}</p>
                            @if($ticket_message->ticketAttachments->count() > 0)
                            <hr>
                            <div class="d-flex">
                                @foreach($ticket_message->ticketAttachments as $attachment)
                                <a href="{{route('admin.tickets_management.tickets.attachment.download',encrypt($attachment->id))}}"><span class="attachment_box mx-2">{{$attachment->file}}</span></a>
                                @endforeach
                            </div>

                            @endif

                        </div>

                        <div class="text-muted mt-1">
                            <small class="dir-ltr d-inline-block">{{$ticket->jalali_created_at}}</small>
                        </div>
                        </div>
                    </div>
                    </li>
                @endif
                @endforeach


            </ul>
        </div>

        </div>
    </div>

    <form action="{{route('admin.tickets_management.tickets.reply',$ticket->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <x-admin.form.text-area sectionClass="my-3" label="{{__('general.message')}}" name="message" required="true" />

        <x-admin.form.file required="false" sectionClass="col-md-6" label="{{__('general.attachment')}}" name="files[]" multiple/>

        <x-admin.form.submit-buttons sectionClass="my-5" />

    </form>
</div>


  @push("scripts")

  <script src="{{asset('assets/js/app-chat.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>

  <script>
    $("[name='status']").on("change",function(){
        var status = $(this).val();
        var ticket_id = "{{$ticket->id}}";
        var url = "{{ route('admin.tickets_management.tickets.change_status', ['ticket_id' => ':ticket_id']) }}";
        url = url.replace(':ticket_id', ticket_id);
        $.ajax({
        url : url,
        data : {"_token": "{{ csrf_token() }}","status":status},
        type : 'post',
        dataType : 'json',
        success : function(result){
            window.location.reload();
        }
        });
    })

  </script>
  @endpush

@endsection
