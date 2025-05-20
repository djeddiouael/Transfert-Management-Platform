  <div class="container section-title" data-aos="fade-up">
    <h2>
        {{ trans('index.search_for') }}
    </h2>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="error-message">
        @if(Session::has('message_search'))
    <p class="alert alert-{{Session::get('error_search')}}">{{ Session::get('message_search') }}</p>
    @endif
    </div>
    <div class="row gy-4">
        <form action="{{ route('book.search') }}" method="post" class="" enctype="multipart/form-data">
            @csrf
            <div class="row gy-4">
                <div class="col-md-6">
                    <input type="text" name="title" class="form-control" placeholder="{{ trans('index.title') }}" required="">
                </div>

                <div class="col-md-6">
                    <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" required>
                        <option value="">{{ trans('index.category') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                </div>
                {{-- <div class="col-md-6">
                    <select class="form-control @error('chefdomaine_id') is-invalid @enderror" name="chefdomaine_id" required>
                        <option value="">{{ trans('index.author') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div> --}}
                {{-- <div class="col-md-6">
                    <input type="text" class="form-control" name="keywords" placeholder="{{ trans('index.keywords') }}" required="">
                </div> --}}
              
                <div class="col-md-12">
                    <button class="btn btn-success cta-btn d-sm-block" type="submit">{{ trans('index.search') }}</button>
                </div>
            </div>
        </form>

</div>
  </div>
  @if(Session::has('books'))
  @include('front.search_result',['books'=>Session::get('books')])
  @endif

