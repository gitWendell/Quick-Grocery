@extends('layouts.app')

@include('inc/inner-header-location')

@section('content')
<div class="container">
    <div class="container contact-us">
        <div class="container">
            @include('inc.messages')
            <h1>Contact Us</h1>
            <form method="POST" action="/contact-us/sendEmail">
                @csrf
                <label class="form-label" for="">Email</label><br/>
                <input class="form-input" name="email" style="width: 100%" type="email" placeholder="Email" required><br/>

                <label class="form-label" for="">Name</label><br/>
                <input class="form-input" style="width: 100%" name="fullname" type="text" placeholder="Full name" required><br/>

                <label for="">Message</label>
                <textarea class="form-textarea" style="width: 100%"
                          name="message"
                          cols="30"
                          rows="10" p
                          placeholder="Tell us your concern" required></textarea>
                <br/>
                <br/>
                <div style="text-align: center;">
                <button type="submit" style="padding: 10px 20px !important;" class="primary-btn">Send</button>
                <br/>
                <br/>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
