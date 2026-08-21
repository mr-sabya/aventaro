<div class="form_container">
    <form wire:submit.prevent="login" class="app-form">
        <div class="mb-3 text-center">
            <h3>Login to your Account</h3>
            <p class="f-s-12 text-secondary">
                Get started with our app, just create an account and enjoy the experience.
            </p>
        </div>

        <div class="mb-3">
            <label class="form-label" for="emailId">Email address</label>
            <input wire:model.defer="email" class="form-control" type="email" id="emailId">
            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            <div class="form-text text">We'll never share your email with anyone else.</div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input wire:model.defer="password" class="form-control" type="password" id="password">
            @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3 form-check">
            <input wire:model="remember" class="form-check-input" id="formCheck1" type="checkbox">
            <label class="form-check-label" for="formCheck1">Remember me</label>
        </div>

        <div>
            <button type="submit" class="btn btn-primary w-100">Continue</button>
        </div>
        <div class="text-center mt-3"><a href="{{route('admin.password.request')}}">Forgot your password?</a></div>
    </form>
</div>
