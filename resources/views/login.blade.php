@extends('index')
@section('title', 'Login Page')
@section('body-id', 'login')

@section('meta')
    <meta name="user_type" content="{{ $userType }}">
@endsection

@section('body')
    <div class="login-container">
        <div class="left-side">
            <h1>{{ \Str::title($userType) }} Login Page</h1>
            <hr style="width:30px">
            <p>See the beauty of the blogging!</p>
        </div>
        <div class="right-side">
            <div class="card shadow">
                <div class="card-body">
                    <form id="frmLogin">
                        <div class="form-floating mb-3">
                            <input type="text" id="username" name="username" class="form-control" placeholder="...">
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" id="password" name="password" class="form-control" placeholder="...">
                            <label for="password">Password</label>
                        </div>
                        <div class="button-group text-end">
                            @if ($userType === 'user')
                                <button id="btnShowRegister" type="button" class="btn btn-light">Register</button>
                            @endif
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                    @if ($userType === 'user')
                        <form id="frmRegister" style="display:none">
                            <div class="form-floating mb-3">
                                <input type="text" id="name" name="name" class="form-control" placeholder="...">
                                <label for="name">Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" id="username" name="username" class="form-control" placeholder="...">
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" id="password" name="password" class="form-control"
                                       placeholder="..."
                                >
                                <label for="password">Password</label>
                            </div>
                            <div class="button-group">
                                <button id="btnShowLogin" type="button" class="btn btn-light"><- Back</button>
                                <button id="btnRegister" type="submit" class="btn btn-primary float-end">Register
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
