  {{-- <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>
        {{ trans('index.registration_from')  }}
    </h2>
    {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
  {{-- </div><!-- End Section Title --> --}} 

  {{-- <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="error-message">
        @if(Session::has('message'))
    <p class="alert alert-{{Session::get('error')}}">{{ Session::get('message') }}</p>
    @endif
    </div>
    <div class="row gy-4">
        <form action="{{ route('student.register') }}" method="post" class="" enctype="multipart/form-data">
            @csrf
            <div class="row gy-4">
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="{{ trans('index.full_name') }}" required="">
                </div>
                <div class="col-md-6">
                    <input type="email" class="form-control" name="email" placeholder="{{ trans('index.email') }}" required="">
                </div>
                <div class="col-md-6">
                    <input type="number" min="1" class="form-control" name="matricule" placeholder="{{ trans('index.matriculation_number') }}" required="">
                </div>
                <div class="col-md-6">
                    <input type="number" min="1" class="form-control" name="phone" placeholder="{{ trans('index.phone_number') }}" required="">
                </div>
                <div class="col-md-12">
                    <button class="btn btn-success cta-btn d-sm-block" type="submit">{{ trans('index.register') }}</button>
                </div>
            </div>
        </form>
</div><!-- End Contact Form --> --}}
  {{-- </div> --}}

