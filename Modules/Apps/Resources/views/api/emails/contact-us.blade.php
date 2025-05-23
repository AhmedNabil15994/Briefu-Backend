@component('mail::message')
<h2> <center>@if(setting('mail_header'))<img src="{{asset(setting('mail_header'))}}" width="100"><br><br>@endif Contact Us Message </center> </h2>
<ul>
  <li>Name : {{ $request['username'] }}</li>
  <li>Mobile : {{ $request['mobile'] }}</li>
  <li>Email : {{ $request['email'] }}</li>
  <li>Message : {{ $request['message'] }}</li>
</ul>
@endcomponent
