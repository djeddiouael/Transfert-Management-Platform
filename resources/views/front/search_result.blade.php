  <!-- Schedule Section -->
  <section id="" class="schedule section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>{{  trans('index.search_result') }}<br></h2>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="tab-content row justify-content-center" data-aos="fade-up" data-aos-delay="200">

        {{-- <h3 class="sub-heading">Voluptatem nulla veniam soluta et corrupti consequatur neque eveniet officia. Eius necessitatibus voluptatem quis labore perspiciatis quia.</h3> --}}

        <!-- Schdule Day 1 -->
        <div role="tabpanel" class="col-lg-9 tab-pane fade show active" id="day-1">
           @foreach ($books as $b)


          <div class="row schedule-item">
            <div class="col-md-4">
                <span>
                 {{ $b->CLE }}
            </span>
        </div>
        <div class="col-md-4">
            <span>
             {{ $b->name }}
        </span>
    </div>
            <div class="col-md-4">
              <p>{{ $b->page_number }}</p>
            </div>
          </div>
          @endforeach


        </div><!-- End Schdule Day 1 -->

      </div>

    </div>
  </section><!-- /Schedule Section -->
