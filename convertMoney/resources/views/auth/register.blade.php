@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{--                        <div class="form-group row">--}}
                            {{--                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>--}}

                            {{--                            <div class="col-md-6">--}}
                            {{--                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>--}}

                            {{--                                @error('name')--}}
                            {{--                                    <span class="invalid-feedback" role="alert">--}}
                            {{--                                        <strong>{{ $message }}</strong>--}}
                            {{--                                    </span>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}

                            {{--                        <div class="form-group row">--}}
                            {{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

                            {{--                            <div class="col-md-6">--}}
                            {{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">--}}

                            {{--                                @error('email')--}}
                            {{--                                    <span class="invalid-feedback" role="alert">--}}
                            {{--                                        <strong>{{ $message }}</strong>--}}
                            {{--                                    </span>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}

                            {{--                        <div class="form-group row">--}}
                            {{--                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

                            {{--                            <div class="col-md-6">--}}
                            {{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">--}}

                            {{--                                @error('password')--}}
                            {{--                                    <span class="invalid-feedback" role="alert">--}}
                            {{--                                        <strong>{{ $message }}</strong>--}}
                            {{--                                    </span>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}

                            {{--                        <div class="form-group row">--}}
                            {{--                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

                            {{--                            <div class="col-md-6">--}}
                            {{--                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}

                            {{--                        <div class="form-group row mb-0">--}}
                            {{--                            <div class="col-md-6 offset-md-4">--}}
                            {{--                                <button type="submit" class="btn btn-primary">--}}
                            {{--                                    {{ __('Register') }}--}}
                            {{--                                </button>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Email</label>
                                            <p class="control has-icons-left has-icons-right">
                                                <input
                                                    class="input is-rounded"
                                                    type="text"
                                                    placeholder="E-mail"
                                                    name="email"
                                                    v-model="email"
                                                />
                                                <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                                                <span class="icon is-small is-right">
                    <i class="fas fa-check"></i>
                  </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">First Name</label>
                                            <p class="control has-icons-left">
                                                <input
                                                    class="input is-rounded"
                                                    type="text"
                                                    placeholder="First Name"
                                                    name="first_name"
                                                    v-model="first_name"
                                                />
                                                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Address</label>
                                            <p class="control has-icons-left">
                                                <input
                                                    class="input is-rounded"
                                                    type="text"
                                                    placeholder="Address"
                                                    name="address"
                                                    v-model="address"
                                                />
                                                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Phone Number</label>
                                            <p class="control has-icons-left">
                                                <input
                                                    class="input is-rounded"
                                                    type="text"
                                                    placeholder="Phone Number"
                                                    name="phone_number"
                                                    v-model="phone_number"
                                                />
                                                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Gender</label>
                                            <p class="control has-icons-left">
                                                <input
                                                    class="input is-rounded"
                                                    type="text"
                                                    placeholder="Gender"
                                                    name="gender"
                                                    v-model="gender"
                                                />
                                                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                                <div class="column">
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">User Name</label>
                                            <p class="control has-icons-left">
                                                <input
                                                    class="input is-rounded"
                                                    type="text"
                                                    placeholder="user_name"
                                                    name="user_name"
                                                    v-model="user_name"
                                                />
                                                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Last Name</label>
                                            <p class="control has-icons-left">
                                                <input
                                                    class="input is-rounded"
                                                    type="text"
                                                    placeholder="Last Name"
                                                    name="last_name"
                                                    v-model="last_name"
                                                />
                                                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Zip Code</label>
                                            <p class="control has-icons-left">
                                                <input
                                                    class="input is-rounded"
                                                    type="text"
                                                    placeholder="Zip Code"
                                                    name="zip_code"
                                                    v-model="zip_code"
                                                />
                                                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Nationality</label>
                                            <p class="control has-icons-left">
                                                <input
                                                    class="input is-rounded"
                                                    type="text"
                                                    placeholder="Nationality"
                                                    name="nationality"
                                                    v-model="nationality"
                                                />
                                                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Commission</label>
                                            <p class="control has-icons-left">
                                                <input
                                                    class="input is-rounded"
                                                    type="text"
                                                    placeholder="Agent Commission"
                                                    name="agent_commission"
                                                    v-model="agent_commission"
                                                />
                                                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="level-left">
                                        Attach Image…… <span style="color: #f14668"> *</span>
                                    </div>
                                    <div class="file">
                                        <label class="file-label">
                                            <input
                                                class="file-input"
                                                type="file"
                                                name="picture"
                                                @change="uploadPictuer"
                                            />
                                            <span class="file-cta">
                    <span class="file-icon">
                      <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                      Choose a file…
                    </span>
                  </span>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="field">
                                <button type="submit" class="button input is-primary">
                                    Register
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        export default {
            data() {
                return {
                    picture: ""
                }
            },
            methods: {
                uploadPictuer(e) {
                    var file = e.target.files[0];
                    var reader = new FileReader();
                    // eslint-disable-next-line no-unused-vars
                    reader.onloadend = (file) => {
                        this.picture = reader.result;
                    };
                    reader.readAsDataURL(file);

                },
            }
        }
    </script>
@endsection
