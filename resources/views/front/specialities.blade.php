{{-- 
<style>
  /* Styles for the images in the speakers section */
  #specialities .member img {
    width: 100%; /* Ensure the image takes the full width of its container */
    height: 200px; /* Set a fixed height for uniformity */
    object-fit: cover; /* Ensures the image covers the entire area without distortion */
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    #specialities .member img {
      height: 150px; /* Adjust height for smaller screens */
    }
  }

  @media (max-width: 576px) {
    #specialities .member img {
      height: 120px; /* Further adjust height for very small screens */
    }
  }
</style>

<section id="specialities" class="speakers section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>
      {{ trans('index.scientific_field_fs') }}
      <br>
    </h2>
  </div><!-- End Section Title -->

  <div class="container">
    <div class="row gy-4">
      @foreach ($categories as $c)
        <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="member">
            @isset($c->image)
              <img src="{{ asset('front/specialities/'.$c->image)}}" class="img-fluid" alt="">
            @else
              <img src="{{ asset('front/specialities/avatar.png')}}" class="img-fluid" alt="">
            @endisset
            <div class="member-info">
              <div class="member-info-content">
                <h4>{{ $c->name}}</h4>
              </div>
              <div class="social">
                @if ($c->website)
                  <a target="_blank" href="{{ $c->website }}"><i class="bi bi-link"></i></a>
                @endif
                @if ($c->facebook)
                  <a target="_blank" href="{{ $c->facebook }}"><i class="bi bi-facebook"></i></a>
                @endif
                @if ($c->telegram)
                  <a target="_blank" href="{{ 'https://t.me/'.$c->telegram }}"><i class="bi bi-telegram"></i></a>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

</section><!-- /Speakers Section -->
--}}
