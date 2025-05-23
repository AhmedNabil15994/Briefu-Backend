@component('mail::message')

<h2> <center>@if(setting('mail_header'))<img src="{{asset(setting('mail_header'))}}" width="100"><br><br>@endif New Consultation </center> </h2>


<ul>
  <li>Name : {{ $user->name }}</li>
  <li>Mobile : {{ $user->mobile }}</li>
  <li>Email : {{ $user->email }}</li>
  <li>Consultation : {{ $request['consultation'] }}</li>
</ul>


@endcomponent
