<!DOCTYPE html>
<html lang="en">
  @include('admin.layouts.partials.head')
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="{{asset('/images/logo.svg')}}">
                </div>
                <h4>New here?</h4>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                <form class="pt-3" action="{{ route('register') }}" method="POST">
                  @csrf
                  <div class="form-group">
                    {{-- <label for="exampleInputUsername1" class="form-control-label" >Name</label> --}}
                    <input type="text" class="form-control form-control-lg" name="name" value="{{ old('name') }}" id="exampleInputUsername1" placeholder="Name">
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                  </div>
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" name="email" value="{{ old('email') }}" placeholder="Email">
                    <p class="text-danger">{{ $errors->first('email') }}</p>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" value="{{ old('password') }}" placeholder="Password">
                    <p class="text-danger">{{ $errors->first('password') }}</p>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword2" name="password_confirmation" placeholder="Confirm Password">
                    <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
                  </div>
                  <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> I agree to all Terms & Conditions </label>
                    </div>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" type="submit">Sign Up</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="{{ route('login')}}" class="text-primary">Login</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    @include('admin.layouts.partials.scripts')
  </body>
</html>