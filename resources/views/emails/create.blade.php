    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title showTitle" id="example-Modal3">Dear All, </h5>
            </div>
            <div class="modal-body" style="height:400px; ">
                <div class="row">
                {{$emailDetails->message }}

                </div>
             
            </div>
    </div>
    @component
    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
