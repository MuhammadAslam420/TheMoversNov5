@extends('admin.layouts.app')

@section('title', 'Company page')

@section('content')
<!-- Start Page content -->
 <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Website Chat</h3>
          </div>
          <div class="card-body">
            <div id="chat-messages" class="mb-3"></div>
            <form id="chat-form"  method="POST">
              @csrf
              <div class="input-group">
                <input type="text" id="message" name="message" class="form-control" placeholder="Type your message...">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary">Send</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- </div> -->

<!-- container -->

{{--</div>--}}
<!-- content -->

<script src="{{asset('assets/js/fetchdata.min.js')}}"></script>

<script>
    $(function() {
    $('body').on('click', '.pagination a', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $.get(url, $('#search').serialize(), function(data){
        $('#js-company-partial-target').html(data);
    });
});

$('#search').on('click', function(e){
    e.preventDefault();
        var search_keyword = $('#search_keyword').val();
        console.log(search_keyword);
        fetch('company/fetch?search='+search_keyword)
        .then(response => response.text())
        .then(html=>{
            document.querySelector('#js-company-partial-target').innerHTML = html
        });
});

});
</script>


@endsection
