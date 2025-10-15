
    <h2>Verify OTP</h2>

    <form method="POST" action="{{ route('admin.verify-otp') }}">
        @csrf
        <div class="form-group">
            <label for="otp">OTP Code</label>
            <input type="text" id="otp" name="otp" class="form-control" required>
            @error('otp')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Verify OTP</button>
    </form>

