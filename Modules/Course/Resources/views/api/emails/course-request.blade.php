@component('mail::message')

    <h2>
        <center>@if(setting('mail_header'))<img src="{{asset(setting('mail_header'))}}" width="100"><br><br>@endif New Course Request</center>
    </h2>
    <ul>
        <li>Course Name : {{ optional($courseUser->course->translate(locale()))->title }}</li>
        <li>Name : {{ $courseUser->name }}</li>
        <li>Email : {{  $courseUser->email }}</li>
        <li>Mobile : {{  ($courseUser->country_code ?? '965').' '.$courseUser->mobile }}</li>
    </ul>
@endcomponent
