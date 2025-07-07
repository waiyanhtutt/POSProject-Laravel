@extends('layouts.register-master')

@section('title','Register')
@section('content')

<div class="card p-4 border-1">
    <div class="w-100">
        <form action="{{route('register')}}" method="POST">
            @csrf

            @error('terms')
                <span class="text-danger"> *
                    {{$message}}
                </span>
            @enderror

            <div class="form-group">
                <label>Username</label>
                <input class="au-input au-input--full" type="text" name="name" placeholder="Username">
                @error('name')
                    <span class="text-danger"> *
                        {{$message}}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                @error('email')
                    <span class="text-danger"> *
                        {{$message}}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input class="au-input au-input--full" type="text" name="phone" placeholder="09*******">
                @error('phone')
                    <span class="text-danger"> *
                        {{$message}}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option selected disabled>Choose Gender...</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                @error('gender')
                    <span class="text-danger"> *
                        {{$message}}
                    </span>
                @enderror
            </div>


            <div class="form-group">
                <label>Address</label>
                <textarea class="au-input au-input--full" name="address" placeholder="Address" rows="2"></textarea>
                @error('address')
                    <span class="text-danger"> *
                        {{$message}}
                    </span>
                @enderror
            </div>


            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                @error('password')
                    <span class="text-danger"> *
                        {{$message}}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password_confirmation" placeholder="Confirm Password">
                @error('password_confirmation')
                    <span class="text-danger"> *
                        {{$message}}
                    </span>
                @enderror
            </div>

            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>

        </form>
        <div class="register-link">
            <p>
                Already have account?
                <a href="{{route('auth#login')}}">Sign In</a>
            </p>
        </div>
    </div>

</div>


@endsection

