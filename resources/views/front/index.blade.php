@include('front.head')
@include('front.header',['categories'=>$categories])

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <img src="{{ asset('front/assets/img/hero-bg.jpg ')}}" alt="" data-aos="fade-in" class="">

      <div class="container d-flex flex-column align-items-center text-center mt-auto">
        <h2 data-aos="fade-up" data-aos-delay="100" class="">
             {{ trans('index.welcome_msg_1')}}
            <br>
            <span>
                {{ trans('index.welcome_msg_2')}}
            </span>
            <br>
            {{ trans('index.welcome_msg_3')}}  </h2>
        <p data-aos="fade-up" data-aos-delay="200">
            {{ trans('index.welcome_msg_4')}}
        </p>
        <div data-aos="fade-up" data-aos-delay="300" class="">
          <a target="_blank" href="https://www.youtube.com/watch?v=lT4qqgxHKmg" class="glightbox play-btn"></a>
        </div>
      </div>

      <div class="about-info mt-auto position-relative">

        {{-- <div class="container position-relative" data-aos="fade-up">
          <div class="row">
            <div class="col-lg-12">
              <h2>About The Event</h2>
             <center>
                <p style="font-size: 1.2rem; line-height: 32px;">
                    {{ trans('index.welcome_msg_5')  }}
                  </p>
             </center>
            </div>

          </div>
        </div> --}}
      </div>

    </section>

    <section id="presentation" class="presentation section">
      @include('front.presentation')
  </section>

    <section id="faculte" class="faculte section">
      @include('front.logofaculter')
  </section>

    <section id="search" class="search section">
        @include('front.chercher',['categories'=>$categories])
    </section>

    {{-- @if(count($categories) > 0)
      @include('front.specialities')
      @endif --}}


      <section id="position" class="venue section">
        @include('front.position')
    </section>


    <section id="faq" class="faq section">
      @include('front.faq')
    </section>



    <section id="contact" class="contact section">

    @include('front.contact')
    </section>

    {{-- <section id="inscrire" class="contact section">
        @include('front.register')
    </section> --}}

  </main>
@include('front.footer')
@include('front.js')
