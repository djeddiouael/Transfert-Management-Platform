  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>
        {{
            trans('index.contact_us')
        }}
    </h2>
  </div>
  

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">

        <div class="col-lg-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt"></i>
                <h3>{{ trans('index.address_title') }}</h3>
                <p>{{ trans('index.address') }}</p>
            </div>
        </div>
        

        <div class="col-lg-3 col-md-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone"></i>
                <h3>{{ trans('index.contact_title') }}</h3>
                <p>{{ trans('index.phone') }}</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope"></i>
                <h3>{{ trans('index.email_title') }}</h3>
                <p>{{ trans('index.emaile') }}</p>
            </div>
        </div>

    </div>
  </div>
